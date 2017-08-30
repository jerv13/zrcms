<?php

namespace Zrcms\Importer\Api;

use Psr\Log\LoggerInterface;
use Zrcms\ContentCore\Container\Api\Action\PublishContainerCmsResource;
use Zrcms\ContentCore\Container\Api\Action\UnpublishContainerCmsResource;
use Zrcms\ContentCore\Container\Api\Repository\InsertContainerVersion;
use Zrcms\ContentCore\Container\Model\ContainerCmsResourceBasic;
use Zrcms\ContentCore\Container\Model\ContainerVersionBasic;
use Zrcms\ContentCore\Container\Model\PropertiesContainerCmsResource;
use Zrcms\ContentCore\Page\Api\Action\PublishPageContainerCmsResource;
use Zrcms\ContentCore\Page\Api\Action\UnpublishPageContainerCmsResource;
use Zrcms\ContentCore\Page\Api\Repository\InsertPageContainerVersion;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResourceBasic;
use Zrcms\ContentCore\Page\Model\PageContainerVersionBasic;
use Zrcms\ContentCore\Page\Model\PropertiesPageContainerCmsResource;
use Zrcms\ContentCore\Site\Api\Action\PublishSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Action\UnpublishSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Repository\InsertSiteVersion;
use Zrcms\ContentCore\Site\Model\PropertiesSiteCmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceBasic;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;
use Zrcms\ContentRedirect\Api\Action\PublishRedirectCmsResource;
use Zrcms\ContentRedirect\Api\Action\UnpublishRedirectCmsResource;
use Zrcms\ContentRedirect\Api\Repository\InsertRedirectVersion;
use Zrcms\ContentRedirect\Model\PropertiesRedirectCmsResource;
use Zrcms\ContentRedirect\Model\RedirectCmsResourceBasic;
use Zrcms\ContentRedirect\Model\RedirectVersionBasic;
use Zrcms\Param\Param;

class Import
{
    const OPTIONS_LOGGER = 'logger';
    const OPTIONS_SLEEP = 'sleep';
    protected $defaultSleep = 0;

    /**
     * @var InsertSiteVersion
     */
    protected $insertSiteVersion;

    /**
     * @var PublishSiteCmsResource
     */
    protected $publishSiteCmsResource;

    /**
     * @var UnpublishSiteCmsResource
     */
    protected $unpublishSiteCmsResource;

    /**
     * @var InsertPageContainerVersion
     */
    protected $insertPageContainerVersion;

    /**
     * @var PublishPageContainerCmsResource
     */
    protected $publishPageContainerCmsResource;

    /**
     * @var UnpublishPageContainerCmsResource
     */
    protected $unpublishPageContainerCmsResource;

    /**
     * @var InsertContainerVersion
     */
    protected $insertContainerVersion;

    /**
     * @var PublishContainerCmsResource
     */
    protected $publishContainerCmsResource;

    /**
     * @var UnpublishContainerCmsResource
     */
    protected $unpublishContainerCmsResource;

    /**
     * @var InsertRedirectVersion
     */
    protected $insertRedirectVersion;

    /**
     * @var PublishRedirectCmsResource
     */
    protected $publishRedirectCmsResource;

    /**
     * @var UnpublishRedirectCmsResource
     */
    protected $unpublishRedirectCmsResource;

    /**
     * @param InsertSiteVersion                 $insertSiteVersion
     * @param PublishSiteCmsResource            $publishSiteCmsResource
     * @param UnpublishSiteCmsResource          $unpublishSiteCmsResource
     * @param InsertPageContainerVersion        $insertPageContainerVersion
     * @param PublishPageContainerCmsResource   $publishPageContainerCmsResource
     * @param UnpublishPageContainerCmsResource $unpublishPageContainerCmsResource
     * @param InsertContainerVersion            $insertContainerVersion
     * @param PublishContainerCmsResource       $publishContainerCmsResource
     * @param UnpublishContainerCmsResource     $unpublishContainerCmsResource
     * @param InsertRedirectVersion             $insertRedirectVersion
     * @param PublishRedirectCmsResource        $publishRedirectCmsResource
     * @param UnpublishRedirectCmsResource      $unpublishRedirectCmsResource
     */
    public function __construct(
        InsertSiteVersion $insertSiteVersion,
        PublishSiteCmsResource $publishSiteCmsResource,
        UnpublishSiteCmsResource $unpublishSiteCmsResource,
        InsertPageContainerVersion $insertPageContainerVersion,
        PublishPageContainerCmsResource $publishPageContainerCmsResource,
        UnpublishPageContainerCmsResource $unpublishPageContainerCmsResource,
        InsertContainerVersion $insertContainerVersion,
        PublishContainerCmsResource $publishContainerCmsResource,
        UnpublishContainerCmsResource $unpublishContainerCmsResource,
        InsertRedirectVersion $insertRedirectVersion,
        PublishRedirectCmsResource $publishRedirectCmsResource,
        UnpublishRedirectCmsResource $unpublishRedirectCmsResource
    ) {
        $this->insertSiteVersion = $insertSiteVersion;
        $this->publishSiteCmsResource = $publishSiteCmsResource;
        $this->unpublishSiteCmsResource = $unpublishSiteCmsResource;

        $this->insertPageContainerVersion = $insertPageContainerVersion;
        $this->publishPageContainerCmsResource = $publishPageContainerCmsResource;
        $this->unpublishPageContainerCmsResource = $unpublishPageContainerCmsResource;

        $this->insertContainerVersion = $insertContainerVersion;
        $this->publishContainerCmsResource = $publishContainerCmsResource;
        $this->unpublishContainerCmsResource = $unpublishContainerCmsResource;

        $this->insertRedirectVersion = $insertRedirectVersion;
        $this->publishRedirectCmsResource = $publishRedirectCmsResource;
        $this->unpublishRedirectCmsResource = $unpublishRedirectCmsResource;
    }

    /**
     * This imports sites, pages, and containers from an exported JSON array into ZRCMS.
     *
     * @param string $json
     * @param string $createdByUserId
     * @param array  $options
     *
     * @return void
     */
    function __invoke(
        string $json,
        string $createdByUserId,
        array $options = []
    ) {
        $data = json_decode($json, true);

        $createdReason = 'Import script ' . get_class($this);

        $this->createRedirects(
            $data['redirects'],
            $createdByUserId,
            $createdReason,
            $options
        );

        $this->createSites(
            $data,
            $createdByUserId,
            $createdReason,
            $options
        );

    }

    /**
     * @param array $options
     *
     * @return void
     */
    protected function sleep(array $options)
    {
        $sleep = Param::getInt(
            $options,
            self::OPTIONS_SLEEP,
            $this->defaultSleep
        );

        if ($sleep) {
            usleep($sleep * 1000000);
        }
    }

    /**
     * @param string $message
     * @param array  $options
     *
     * @return void
     */
    protected function log(
        string $message,
        array $options
    ) {
        $logger = Param::get(
            $options,
            self::OPTIONS_LOGGER
        );

        if ($logger instanceof LoggerInterface) {
            $logger->debug($message);
            $this->sleep($options);
        }
    }

    /**
     * @param array  $data
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $options
     *
     * @return void
     */
    protected function createSites(
        array $data,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ) {
        foreach ($data['sites'] as $site) {
            $this->log(
                'executing insertSiteVersion('
                . 'siteId:' . $site['id']
                . ',host:' . $site['host']
                . ')',
                $options
            );
            $version = $this->insertSiteVersion->__invoke(
                new SiteVersionBasic(
                    $site['properties'],
                    $createdByUserId,
                    $createdReason
                )
            );

            $this->log(
                'executing publishSiteCmsResource('
                . 'siteId:' . $site['id']
                . ',host:' . $site['host']
                . ')',
                $options
            );
            $publishedSiteCmsResource = $this->publishSiteCmsResource->__invoke(
                new SiteCmsResourceBasic(
                    [
                        PropertiesSiteCmsResource::ID => $site['id'],
                        PropertiesSiteCmsResource::HOST => $site['host'],
                        PropertiesSiteCmsResource::CONTENT_VERSION_ID => $version->getId(),
                    ],
                    $createdByUserId,
                    $createdReason
                ),
                $createdByUserId,
                $createdReason
            );

            $this->createPages(
                $publishedSiteCmsResource,
                $site['pages'],
                $createdByUserId,
                $createdReason,
                $options
            );

            $this->createContainers(
                $publishedSiteCmsResource,
                $site['containers'],
                $createdByUserId,
                $createdReason,
                $options
            );

            if (!Param::getBool($site, 'published', true)) {
                $this->log(
                    'UNPUBLISH site ID: ' . $publishedSiteCmsResource->getId(),
                    $options
                );

                $this->unpublishSiteCmsResource->__invoke(
                    $publishedSiteCmsResource,
                    $createdByUserId,
                    $createdReason
                );
            }
        }
    }

    /**
     * @param SiteCmsResource $siteCmsResource
     * @param array           $pages
     * @param string          $createdByUserId
     * @param string          $createdReason
     * @param array           $options
     *
     * @return void
     */
    protected function createPages(
        SiteCmsResource $siteCmsResource,
        array $pages,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ) {
        foreach ($pages as $page) {

            $this->log(
                'executing insertPageContainerVersion('
                . 'siteId:' . $page['siteId'] . ',path:' . $page['path']
                . ')',
                $options
            );
            $version = $this->insertPageContainerVersion->__invoke(
                new PageContainerVersionBasic(
                    $page['properties'],
                    $createdByUserId,
                    $createdReason
                )
            );

            $this->log(
                'executing publishPageContainerCmsResource('
                . 'siteId:' . $page['siteId'] . ',path:' . $page['path']
                . ')',
                $options
            );
            $publishedPageContainerCmsResource = $this->publishPageContainerCmsResource->__invoke(
                new PageContainerCmsResourceBasic(
                    [
                        PropertiesPageContainerCmsResource::SITE_CMS_RESOURCE_ID => $siteCmsResource->getId(),
                        PropertiesPageContainerCmsResource::PATH => $page['path'],
                        PropertiesPageContainerCmsResource::CONTENT_VERSION_ID => $version->getId(),
                    ],
                    $createdByUserId,
                    $createdReason
                ),
                $createdByUserId,
                $createdReason
            );

            if (!Param::getBool($page, 'published', true)) {
                $this->log(
                    'UNPUBLISH page ID: ' . $publishedPageContainerCmsResource->getId(),
                    $options
                );

                $this->unpublishPageContainerCmsResource->__invoke(
                    $publishedPageContainerCmsResource,
                    $createdByUserId,
                    $createdReason
                );
            }
        }
    }

    /**
     * @param SiteCmsResource $siteCmsResource
     * @param array           $containers
     * @param string          $createdByUserId
     * @param string          $createdReason
     * @param array           $options
     *
     * @return void
     */
    protected function createContainers(
        SiteCmsResource $siteCmsResource,
        array $containers,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ) {
        foreach ($containers as $container) {

            $this->log(
                'executing insertContainerVersion('
                . 'siteId:' . $container['siteId'] . ',path:' . $container['path']
                . ')',
                $options
            );
            $version = $this->insertContainerVersion->__invoke(
                new ContainerVersionBasic(
                    $container['properties'],
                    $createdByUserId,
                    $createdReason
                )
            );

            $this->log(
                'executing publishContainerCmsResource('
                . 'siteId:' . $container['siteId'] . ',path:' . $container['path']
                . ')',
                $options
            );
            $publishedContainerCmsResource = $this->publishContainerCmsResource->__invoke(
                new ContainerCmsResourceBasic(
                    [
                        PropertiesContainerCmsResource::SITE_CMS_RESOURCE_ID => $siteCmsResource->getId(),
                        PropertiesContainerCmsResource::PATH => $container['path'],
                        PropertiesContainerCmsResource::CONTENT_VERSION_ID => $version->getId(),
                    ],
                    $createdByUserId,
                    $createdReason
                ),
                $createdByUserId,
                $createdReason
            );

            if (!Param::getBool($container, 'published', true)) {
                $this->log(
                    'UNPUBLISH container ID: ' . $publishedContainerCmsResource->getId(),
                    $options
                );

                $this->unpublishContainerCmsResource->__invoke(
                    $publishedContainerCmsResource,
                    $createdByUserId,
                    $createdReason
                );
            }
        }
    }

    /**
     * @param SiteCmsResource $siteCmsResource
     * @param array           $layouts
     * @param string          $createdByUserId
     * @param string          $createdReason
     * @param array           $options
     *
     * @return void
     */
    protected function createLayouts(
        SiteCmsResource $siteCmsResource,
        array $layouts,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ) {
        // @todo
    }

    /**
     * @param array  $redirects
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $options
     *
     * @return void
     */
    protected function createRedirects(
        array $redirects,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ) {
        foreach ($redirects as $redirect) {

            $this->log(
                'executing insertRedirectVersion('
                . 'siteId:' . $redirect['siteId'] . ',requestPath:' . $redirect['requestPath']
                . ')',
                $options
            );
            $version = $this->insertRedirectVersion->__invoke(
                new RedirectVersionBasic(
                    $redirect['properties'],
                    $createdByUserId,
                    $createdReason
                )
            );

            $this->log(
                'executing publishRedirectCmsResource('
                . 'siteId:' . $redirect['siteId'] . ',requestPath:' . $redirect['requestPath']
                . ')',
                $options
            );
            $publishedRedirectCmsResource = $this->publishRedirectCmsResource->__invoke(
                new RedirectCmsResourceBasic(
                    [
                        PropertiesRedirectCmsResource::SITE_CMS_RESOURCE_ID => $redirect['siteId'],
                        PropertiesRedirectCmsResource::REQUEST_PATH => $redirect['requestPath'],
                        PropertiesRedirectCmsResource::CONTENT_VERSION_ID => $version->getId(),
                        PropertiesRedirectCmsResource::PUBLISHED => Param::getBool($redirect, 'published', true),
                    ],
                    $createdByUserId,
                    $createdReason
                ),
                $createdByUserId,
                $createdReason
            );
            if (!Param::getBool($redirect, 'published', true)) {
                $this->log(
                    'UNPUBLISH redirect ID: ' . $publishedRedirectCmsResource->getId(),
                    $options
                );

                $this->unpublishRedirectCmsResource->__invoke(
                    $publishedRedirectCmsResource,
                    $createdByUserId,
                    $createdReason
                );
            }
        }
    }
}
