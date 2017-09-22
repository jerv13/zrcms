<?php

namespace Zrcms\Importer\Api;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Zrcms\ContentCore\Container\Api\Action\PublishContainerCmsResource;
use Zrcms\ContentCore\Container\Api\Action\UnpublishContainerCmsResource;
use Zrcms\ContentCore\Container\Api\Repository\InsertContainerVersion;
use Zrcms\ContentCore\Container\Fields\FieldsContainerCmsResource;
use Zrcms\ContentCore\Container\Model\ContainerCmsResourceBasic;
use Zrcms\ContentCore\Container\Model\ContainerVersionBasic;
use Zrcms\ContentCore\Page\Api\Action\PublishPageContainerCmsResource;
use Zrcms\ContentCore\Page\Api\Action\PublishPageTemplateCmsResource;
use Zrcms\ContentCore\Page\Api\Action\UnpublishPageContainerCmsResource;
use Zrcms\ContentCore\Page\Api\Action\UnpublishPageTemplateCmsResource;
use Zrcms\ContentCore\Page\Api\Repository\InsertPageContainerVersion;
use Zrcms\ContentCore\Page\Fields\FieldsPageContainerCmsResource;
use Zrcms\ContentCore\Page\Fields\FieldsPageTemplateCmsResource;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResourceBasic;
use Zrcms\ContentCore\Page\Model\PageContainerVersionBasic;
use Zrcms\ContentCore\Page\Model\PageTemplateCmsResourceBasic;
use Zrcms\ContentCore\Site\Api\Action\PublishSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Action\UnpublishSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Repository\InsertSiteVersion;
use Zrcms\ContentCore\Site\Fields\FieldsSiteCmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceBasic;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;
use Zrcms\ContentRedirect\Api\Action\PublishRedirectCmsResource;
use Zrcms\ContentRedirect\Api\Action\UnpublishRedirectCmsResource;
use Zrcms\ContentRedirect\Api\Repository\InsertRedirectVersion;
use Zrcms\ContentRedirect\Fields\FieldsRedirectCmsResource;
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
     * @var PublishPageTemplateCmsResource
     */
    protected $publishPageTemplateCmsResource;

    /**
     * @var UnpublishPageTemplateCmsResource
     */
    protected $unpublishPageTemplateCmsResource;

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
     * @param PublishPageTemplateCmsResource    $publishPageTemplateCmsResource
     * @param UnpublishPageTemplateCmsResource  $unpublishPageTemplateCmsResource
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
        PublishPageTemplateCmsResource $publishPageTemplateCmsResource,
        UnpublishPageTemplateCmsResource $unpublishPageTemplateCmsResource,
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

        $this->publishPageTemplateCmsResource = $publishPageTemplateCmsResource;
        $this->unpublishPageTemplateCmsResource = $unpublishPageTemplateCmsResource;

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
        string $level,
        string $message,
        array $options
    ) {
        $logger = Param::get(
            $options,
            self::OPTIONS_LOGGER
        );

        if ($logger instanceof LoggerInterface) {
            $logger->log($level, $message);
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
                LogLevel::INFO,
                'Insert SiteVersion('
                . 'siteId:' . $site['id']
                . ',host:' . $site['host']
                . ')',
                $options
            );
            $version = $this->insertSiteVersion->__invoke(
                new SiteVersionBasic(
                    null,
                    $site['properties'],
                    $createdByUserId,
                    $createdReason
                )
            );

            $this->log(
                LogLevel::INFO,
                'Publish SiteCmsResource('
                . 'siteId:' . $site['id']
                . ',host:' . $site['host']
                . ')',
                $options
            );
            $publishedSiteCmsResource = $this->publishSiteCmsResource->__invoke(
                new SiteCmsResourceBasic(
                    $site['id'],
                    true,
                    $version,
                    [
                        FieldsSiteCmsResource::HOST => $site['host'],
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

            $this->createPageTemplates(
                $publishedSiteCmsResource,
                $site['pageTemplates'],
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
                    LogLevel::WARNING,
                    'UNPUBLISH SiteCmsResource ID: ' . $publishedSiteCmsResource->getId(),
                    $options
                );

                $this->unpublishSiteCmsResource->__invoke(
                    $publishedSiteCmsResource->getId(),
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
                LogLevel::INFO,
                'Insert PageContainerVersion('
                . 'siteId:' . $page['siteId'] . ',path:' . $page['path']
                . ')',
                $options
            );
            $version = $this->insertPageContainerVersion->__invoke(
                new PageContainerVersionBasic(
                    null,
                    $page['properties'],
                    $createdByUserId,
                    $createdReason
                )
            );

            $this->log(
                LogLevel::INFO,
                'Publish PageContainerCmsResource('
                . 'siteId:' . $page['siteId'] . ',path:' . $page['path']
                . ')',
                $options
            );
            $publishedPageContainerCmsResource = $this->publishPageContainerCmsResource->__invoke(
                new PageContainerCmsResourceBasic(
                    null,
                    true,
                    $version,
                    [
                        FieldsPageContainerCmsResource::SITE_CMS_RESOURCE_ID => $siteCmsResource->getId(),
                        FieldsPageContainerCmsResource::PATH => $page['path'],
                    ],
                    $createdByUserId,
                    $createdReason
                ),
                $createdByUserId,
                $createdReason
            );

            if (!Param::getBool($page, 'published', true)) {
                $this->log(
                    LogLevel::WARNING,
                    'UNPUBLISH PageContainerCmsResource ID: ' . $publishedPageContainerCmsResource->getId(),
                    $options
                );

                $this->unpublishPageContainerCmsResource->__invoke(
                    $publishedPageContainerCmsResource->getId(),
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
    protected function createPageTemplates(
        SiteCmsResource $siteCmsResource,
        array $pages,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ) {
        foreach ($pages as $page) {

            $this->log(
                LogLevel::INFO,
                'Insert PageContainerVersion('
                . 'siteId:' . $page['siteId'] . ',path:' . $page['path']
                . ')',
                $options
            );
            $version = $this->insertPageContainerVersion->__invoke(
                new PageContainerVersionBasic(
                    null,
                    $page['properties'],
                    $createdByUserId,
                    $createdReason
                )
            );

            $this->log(
                LogLevel::INFO,
                'Publish PageTemplateCmsResource('
                . 'siteId:' . $page['siteId'] . ',path:' . $page['path']
                . ')',
                $options
            );
            $publishedPageTemplateCmsResource = $this->publishPageTemplateCmsResource->__invoke(
                new PageTemplateCmsResourceBasic(
                    null,
                    true,
                    $version,
                    [
                        FieldsPageTemplateCmsResource::SITE_CMS_RESOURCE_ID => $siteCmsResource->getId(),
                        FieldsPageTemplateCmsResource::PATH => $page['path'],
                    ],
                    $createdByUserId,
                    $createdReason
                ),
                $createdByUserId,
                $createdReason
            );

            if (!Param::getBool($page, 'published', true)) {
                $this->log(
                    LogLevel::WARNING,
                    'UNPUBLISH PageTemplateCmsResource ID: ' . $publishedPageTemplateCmsResource->getId(),
                    $options
                );

                $this->unpublishPageTemplateCmsResource->__invoke(
                    $publishedPageTemplateCmsResource->getId(),
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
                LogLevel::INFO,
                'Insert ContainerVersion('
                . 'siteId:' . $container['siteId'] . ',path:' . $container['path']
                . ')',
                $options
            );
            $version = $this->insertContainerVersion->__invoke(
                new ContainerVersionBasic(
                    null,
                    $container['properties'],
                    $createdByUserId,
                    $createdReason
                )
            );

            $this->log(
                LogLevel::INFO,
                'Publish ContainerCmsResource('
                . 'siteId:' . $container['siteId'] . ',path:' . $container['path']
                . ')',
                $options
            );
            $publishedContainerCmsResource = $this->publishContainerCmsResource->__invoke(
                new ContainerCmsResourceBasic(
                    null,
                    true,
                    $version,
                    [
                        FieldsContainerCmsResource::SITE_CMS_RESOURCE_ID => $siteCmsResource->getId(),
                        FieldsContainerCmsResource::PATH => $container['path'],
                    ],
                    $createdByUserId,
                    $createdReason
                ),
                $createdByUserId,
                $createdReason
            );

            if (!Param::getBool($container, 'published', true)) {
                $this->log(
                    LogLevel::WARNING,
                    'UNPUBLISH ContainerCmsResource ID: ' . $publishedContainerCmsResource->getId(),
                    $options
                );

                $this->unpublishContainerCmsResource->__invoke(
                    $publishedContainerCmsResource->getId(),
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
                LogLevel::INFO,
                'Insert RedirectVersion('
                . 'siteId:' . $redirect['siteId'] . ',requestPath:' . $redirect['requestPath']
                . ')',
                $options
            );
            $version = $this->insertRedirectVersion->__invoke(
                new RedirectVersionBasic(
                    null,
                    $redirect['properties'],
                    $createdByUserId,
                    $createdReason
                )
            );

            $this->log(
                LogLevel::INFO,
                'Publish RedirectCmsResource('
                . 'siteId:' . $redirect['siteId'] . ',requestPath:' . $redirect['requestPath']
                . ')',
                $options
            );

            $publishedRedirectCmsResource = $this->publishRedirectCmsResource->__invoke(
                new RedirectCmsResourceBasic(
                    null,
                    true,
                    $version,
                    [
                        FieldsRedirectCmsResource::SITE_CMS_RESOURCE_ID => $redirect['siteId'],
                        FieldsRedirectCmsResource::REQUEST_PATH => $redirect['requestPath'],
                    ],
                    $createdByUserId,
                    $createdReason
                ),
                $createdByUserId,
                $createdReason
            );

            if (!Param::getBool($redirect, 'published', true)) {
                $this->log(
                    LogLevel::WARNING,
                    'UNPUBLISH RedirectCmsResource ID: ' . $publishedRedirectCmsResource->getId(),
                    $options
                );

                $this->unpublishRedirectCmsResource->__invoke(
                    $publishedRedirectCmsResource->getId(),
                    $createdByUserId,
                    $createdReason
                );
            }
        }
    }
}
