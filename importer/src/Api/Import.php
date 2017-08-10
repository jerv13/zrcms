<?php

namespace Zrcms\Importer\Api;

use Psr\Log\LoggerInterface;
use Zrcms\ContentCore\Container\Api\Action\PublishContainerCmsResource;
use Zrcms\ContentCore\Container\Api\Repository\InsertContainerVersion;
use Zrcms\ContentCore\Container\Model\ContainerCmsResourceBasic;
use Zrcms\ContentCore\Container\Model\ContainerVersionBasic;
use Zrcms\ContentCore\Container\Model\PropertiesContainerCmsResource;
use Zrcms\ContentCore\Page\Api\Action\PublishPageContainerCmsResource;
use Zrcms\ContentCore\Page\Api\Repository\InsertPageContainerVersion;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResourceBasic;
use Zrcms\ContentCore\Page\Model\PageContainerVersionBasic;
use Zrcms\ContentCore\Page\Model\PropertiesPageContainerCmsResource;
use Zrcms\ContentCore\Site\Api\Action\PublishSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Repository\InsertSiteVersion;
use Zrcms\ContentCore\Site\Model\PropertiesSiteCmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceBasic;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;

class Import
{
    /**
     * @var InsertSiteVersion
     */
    protected $insertSiteVersion;

    /**
     * @var PublishSiteCmsResource
     */
    protected $publishSiteCmsResource;

    /**
     * @var InsertPageContainerVersion
     */
    protected $insertPageContainerVersion;

    /**
     * @var PublishPageContainerCmsResource
     */
    protected $publishPageContainerCmsResource;

    /**
     * @var InsertContainerVersion
     */
    protected $insertContainerVersion;

    /**
     * @var PublishContainerCmsResource
     */
    protected $publishContainerCmsResource;

    /**
     * @param InsertSiteVersion $insertSiteVersion
     * @param PublishSiteCmsResource $publishSiteCmsResource
     * @param InsertPageContainerVersion $insertPageContainerVersion
     * @param PublishPageContainerCmsResource $publishPageContainerCmsResource
     * @param InsertContainerVersion $insertContainerVersion
     * @param PublishContainerCmsResource $publishContainerCmsResource
     */
    public function __construct(
        InsertSiteVersion $insertSiteVersion,
        PublishSiteCmsResource $publishSiteCmsResource,
        InsertPageContainerVersion $insertPageContainerVersion,
        PublishPageContainerCmsResource $publishPageContainerCmsResource,
        InsertContainerVersion $insertContainerVersion,
        PublishContainerCmsResource $publishContainerCmsResource
    ) {
        $this->insertSiteVersion = $insertSiteVersion;
        $this->publishSiteCmsResource = $publishSiteCmsResource;
        $this->insertPageContainerVersion = $insertPageContainerVersion;
        $this->publishPageContainerCmsResource = $publishPageContainerCmsResource;
        $this->insertContainerVersion = $insertContainerVersion;
        $this->publishContainerCmsResource = $publishContainerCmsResource;
    }

    /**
     * This imports sites, pages, and containers from an exported JSON array into the database.
     *
     * @param string $json The full json data string from a previous Zrcms export
     * @param string $createdByUserId
     *
     * @return void
     */
    function __invoke(string $json, string $createdByUserId, LoggerInterface $logger)
    {
        $data = json_decode($json, true);

        $createdReason = 'Import script ' . get_class($this);

        $this->createSites(
            $data,
            $createdByUserId,
            $createdReason,
            $logger
        );
    }

    /**
     * @param array $data
     * @param string $createdByUserId
     * @param string $createdReason
     *
     * @return void
     */
    protected function createSites(
        array $data,
        string $createdByUserId,
        string $createdReason,
        LoggerInterface $logger
    ) {

        foreach ($data['sites'] as $site) {
            $logger->debug(
                'executing insertSiteVersion('
                . 'siteId:' . $site['id']
                . ')'
            );
            $version = $this->insertSiteVersion->__invoke(
                new SiteVersionBasic(
                    $site['properties'],
                    $createdByUserId,
                    $createdReason
                )
            );

            $logger->debug(
                'executing publishSiteCmsResource('
                . 'siteId:' . $site['id']
                . ')'
            );
            $publishedSiteCmsResource = $this->publishSiteCmsResource->__invoke(
                new SiteCmsResourceBasic(
                    [
                        PropertiesSiteCmsResource::ID => $site['id'],
                        PropertiesSiteCmsResource::HOST => $site['host'],
                        PropertiesSiteCmsResource::CONTENT_VERSION_ID => $version->getId()
                    ],
                    $createdByUserId,
                    $createdReason
                ),
                $createdByUserId,
                $createdReason
            );

            $this->createPages(
                $publishedSiteCmsResource,
                $data['pages'],
                $createdByUserId,
                $createdReason,
                $logger
            );

            $this->createContainers(
                $publishedSiteCmsResource,
                $data['containers'],
                $createdByUserId,
                $createdReason,
                $logger
            );
        }
    }

    protected function createPages(
        SiteCmsResource $siteCmsResource,
        array $pages,
        string $createdByUserId,
        string $createdReason,
        LoggerInterface $logger
    ) {
        foreach ($pages as $page) {

            $logger->debug(
                'executing insertPageContainerVersion('
                . 'siteId:' . $page['siteId'] . ',path:' . $page['path']
                . ')'
            );
            $version = $this->insertPageContainerVersion->__invoke(
                new PageContainerVersionBasic(
                    $page['properties'],
                    $createdByUserId,
                    $createdReason
                )
            );

            $logger->debug(
                'executing publishPageContainerCmsResource('
                . 'siteId:' . $page['siteId'] . ',path:' . $page['path']
                . ')'
            );
            $publishedPageContainerCmsResource = $this->publishPageContainerCmsResource->__invoke(
                new PageContainerCmsResourceBasic(
                    [
                        PropertiesPageContainerCmsResource::SITE_CMS_RESOURCE_ID => $siteCmsResource->getId(),
                        PropertiesPageContainerCmsResource::PATH => $page['path'],
                        PropertiesPageContainerCmsResource::CONTENT_VERSION_ID => $version->getId()
                    ],
                    $createdByUserId,
                    $createdReason
                ),
                $createdByUserId,
                $createdReason
            );
        }
    }

    protected function createContainers(
        SiteCmsResource $siteCmsResource,
        array $containers,
        string $createdByUserId,
        string $createdReason,
        LoggerInterface $logger
    ) {
        foreach ($containers as $container) {

            $logger->debug(
                'executing insertContainerVersion('
                . 'siteId:' . $container['siteId'] . ',path:' . $container['path']
                . ')'
            );
            $version = $this->insertContainerVersion->__invoke(
                new ContainerVersionBasic(
                    $container['properties'],
                    $createdByUserId,
                    $createdReason
                )
            );

            $logger->debug(
                'executing publishContainerCmsResource('
                . 'siteId:' . $container['siteId'] . ',path:' . $container['path']
                . ')'
            );
            $publishedContainerCmsResource = $this->publishContainerCmsResource->__invoke(
                new ContainerCmsResourceBasic(
                    [
                        PropertiesContainerCmsResource::SITE_CMS_RESOURCE_ID => $siteCmsResource->getId(),
                        PropertiesContainerCmsResource::PATH => $container['path'],
                        PropertiesContainerCmsResource::CONTENT_VERSION_ID => $version->getId()
                    ],
                    $createdByUserId,
                    $createdReason
                ),
                $createdByUserId,
                $createdReason
            );
        }
    }

    protected function createLayouts(
        SiteCmsResource $siteCmsResource,
        array $layouts,
        string $createdByUserId,
        string $createdReason
    ) {
        // @todo
    }
}
