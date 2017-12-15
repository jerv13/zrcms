<?php

namespace Zrcms\Importer\Api;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Zrcms\CoreContainer\Api\CmsResource\UpsertContainerCmsResource;
use Zrcms\CoreContainer\Fields\FieldsContainerVersion;
use Zrcms\CoreContainer\Model\ContainerCmsResourceBasic;
use Zrcms\CoreContainer\Model\ContainerVersionBasic;
use Zrcms\CorePage\Api\CmsResource\UpsertPageCmsResource;
use Zrcms\CorePage\Api\CmsResource\UpsertPageTemplateCmsResource;
use Zrcms\CorePage\Fields\FieldsPageVersion;
use Zrcms\CorePage\Model\PageCmsResourceBasic;
use Zrcms\CorePage\Model\PageTemplateCmsResourceBasic;
use Zrcms\CorePage\Model\PageVersionBasic;
use Zrcms\CoreSite\Api\CmsResource\UpsertSiteCmsResource;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResource;
use Zrcms\CoreSite\Model\SiteCmsResource;
use Zrcms\CoreSite\Model\SiteCmsResourceBasic;
use Zrcms\CoreSite\Model\SiteVersionBasic;
use Zrcms\CoreRedirect\Api\CmsResource\UpsertRedirectCmsResource;
use Zrcms\CoreRedirect\Model\RedirectCmsResourceBasic;
use Zrcms\CoreRedirect\Model\RedirectVersionBasic;
use Zrcms\Param\Param;

class Import
{
    const OPTIONS_LOGGER = 'logger';
    const OPTIONS_SLEEP = 'sleep';
    const OPTIONS_SKIP_DUPLICATES = 'skip-duplicates';
    protected $defaultSleep = 0;
    protected $defaultSkipDuplicates = true;

    /**
     * @var FindSiteCmsResource
     */
    protected $findSiteCmsResource;

    /**
     * @var UpsertSiteCmsResource
     */
    protected $upsertSiteCmsResource;

    /**
     * @var UpsertPageCmsResource
     */
    protected $upsertPageCmsResource;

    /**
     * @var UpsertPageTemplateCmsResource
     */
    protected $upsertPageTemplateCmsResource;

    /**
     * @var UpsertContainerCmsResource
     */
    protected $upsertContainerCmsResource;

    /**
     * @var UpsertRedirectCmsResource
     */
    protected $upsertRedirectCmsResource;

    /**
     * @param FindSiteCmsResource           $findSiteCmsResource
     * @param UpsertSiteCmsResource         $upsertSiteCmsResource
     * @param UpsertPageCmsResource         $upsertPageCmsResource
     * @param UpsertPageTemplateCmsResource $upsertPageTemplateCmsResource
     * @param UpsertContainerCmsResource    $upsertContainerCmsResource
     * @param UpsertRedirectCmsResource     $upsertRedirectCmsResource
     */
    public function __construct(
        FindSiteCmsResource $findSiteCmsResource,
        UpsertSiteCmsResource $upsertSiteCmsResource,
        UpsertPageCmsResource $upsertPageCmsResource,
        UpsertPageTemplateCmsResource $upsertPageTemplateCmsResource,
        UpsertContainerCmsResource $upsertContainerCmsResource,
        UpsertRedirectCmsResource $upsertRedirectCmsResource
    ) {
        $this->findSiteCmsResource = $findSiteCmsResource;
        $this->upsertSiteCmsResource = $upsertSiteCmsResource;
        $this->upsertPageCmsResource = $upsertPageCmsResource;
        $this->upsertPageTemplateCmsResource = $upsertPageTemplateCmsResource;
        $this->upsertContainerCmsResource = $upsertContainerCmsResource;
        $this->upsertRedirectCmsResource = $upsertRedirectCmsResource;
    }

    /**
     * This imports sites, pages, and containers from an exported JSON array into ZRCMS.
     *
     * @param string $json
     * @param string $createdByUserId
     * @param array  $options
     *
     * @return void
     * @throws \Exception
     */
    public function __invoke(
        string $json,
        string $createdByUserId,
        array $options = []
    ) {
        $startTime = time();

        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Received invalid JSON');
        }

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

        $this->log(
            LogLevel::INFO,
            'Import COMPLETE in ' . time() - $startTime . 'seconds',
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
     * @param array $options
     *
     * @return bool
     */
    protected function skipDuplicates(array $options): bool
    {
        return Param::getBool(
            $options,
            self::OPTIONS_SKIP_DUPLICATES,
            $this->defaultSkipDuplicates
        );
    }

    /**
     * @param string $level
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
        $this->log(
            LogLevel::INFO,
            'Import Sites:',
            $options
        );

        foreach ($data['sites'] as $site) {
            $existing = $this->findSiteCmsResource->__invoke(
                $site['id']
            );

            if (!empty($existing) && $this->skipDuplicates($options)) {
                $this->log(
                    LogLevel::WARNING,
                    'SKIP Site - Already exists: ('
                    . 'siteId: ' . $site['id']
                    . ', host: ' . $site['properties']['host']
                    . ')',
                    $options
                );
                continue;
            }

            $this->log(
                LogLevel::INFO,
                'Import Site: ('
                . 'siteId: ' . $site['id']
                . ', host: ' . $site['properties']['host']
                . ')',
                $options
            );

            $published = Param::getBool($site, 'published', true);

            $publishedSiteCmsResource = $this->upsertSiteCmsResource->__invoke(
                new SiteCmsResourceBasic(
                    $site['id'],
                    $published,
                    new SiteVersionBasic(
                        null,
                        $site['properties'],
                        $createdByUserId,
                        $createdReason
                    ),
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

            if (!$published) {
                $this->log(
                    LogLevel::WARNING,
                    'UNPUBLISH SiteCmsResource ID: ' . $publishedSiteCmsResource->getId(),
                    $options
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
        $this->log(
            LogLevel::INFO,
            'Import Pages: ('
            . 'siteId: ' . $siteCmsResource->getId()
            . ')',
            $options
        );

        foreach ($pages as $page) {
            $this->log(
                LogLevel::INFO,
                'Import Page: ' . $page['properties']['path'] . ' ID: ' . $page['id'],
                $options
            );

            $page['properties'][FieldsPageVersion::SITE_CMS_RESOURCE_ID] = $siteCmsResource->getId();

            $published = Param::getBool($page, 'published', true);

            $publishedPageCmsResource = $this->upsertPageCmsResource->__invoke(
                new PageCmsResourceBasic(
                    $page['id'],
                    $published,
                    new PageVersionBasic(
                        null,
                        $page['properties'],
                        $createdByUserId,
                        $createdReason
                    ),
                    $createdByUserId,
                    $createdReason
                ),
                $createdByUserId,
                $createdReason
            );

            if (!$published) {
                $this->log(
                    LogLevel::WARNING,
                    'UNPUBLISH PageCmsResource ID: ' . $publishedPageCmsResource->getId(),
                    $options
                );
            }
        }
    }

    /**
     * @param SiteCmsResource $siteCmsResource
     * @param array           $pageTemplates
     * @param string          $createdByUserId
     * @param string          $createdReason
     * @param array           $options
     *
     * @return void
     */
    protected function createPageTemplates(
        SiteCmsResource $siteCmsResource,
        array $pageTemplates,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ) {
        $this->log(
            LogLevel::INFO,
            'Import Page Templates: ('
            . 'siteId: ' . $siteCmsResource->getId()
            . ')',
            $options
        );

        foreach ($pageTemplates as $pageTemplate) {
            $this->log(
                LogLevel::INFO,
                'Import Page Template: ' . $pageTemplate['properties']['path'],
                $options
            );

            $pageTemplate['properties'][FieldsPageVersion::SITE_CMS_RESOURCE_ID] = $siteCmsResource->getId();

            $published = Param::getBool($pageTemplate, 'published', true);

            $publishedPageTemplateCmsResource = $this->upsertPageTemplateCmsResource->__invoke(
                new PageTemplateCmsResourceBasic(
                    $pageTemplate['id'],
                    $published,
                    new PageVersionBasic(
                        null,
                        $pageTemplate['properties'],
                        $createdByUserId,
                        $createdReason
                    ),
                    $createdByUserId,
                    $createdReason
                ),
                $createdByUserId,
                $createdReason
            );

            if (!$published) {
                $this->log(
                    LogLevel::WARNING,
                    'UNPUBLISH PageTemplateCmsResource ID: ' . $publishedPageTemplateCmsResource->getId(),
                    $options
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
        $this->log(
            LogLevel::INFO,
            'Import Containers: ('
            . 'siteId: ' . $siteCmsResource->getId()
            . ')',
            $options
        );

        foreach ($containers as $container) {
            $this->log(
                LogLevel::INFO,
                'Import Container: ' . $container['properties']['path'],
                $options
            );

            $container['properties'][FieldsContainerVersion::SITE_CMS_RESOURCE_ID] = $siteCmsResource->getId();

            $published = Param::getBool($container, 'published', true);

            $publishedContainerCmsResource = $this->upsertContainerCmsResource->__invoke(
                new ContainerCmsResourceBasic(
                    $container['id'],
                    $published,
                    new ContainerVersionBasic(
                        null,
                        $container['properties'],
                        $createdByUserId,
                        $createdReason
                    ),
                    $createdByUserId,
                    $createdReason
                ),
                $createdByUserId,
                $createdReason
            );

            if (!$published) {
                $this->log(
                    LogLevel::WARNING,
                    'UNPUBLISH ContainerCmsResource ID: ' . $publishedContainerCmsResource->getId(),
                    $options
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
        $this->log(
            LogLevel::INFO,
            'Import Redirects: ',
            $options
        );

        foreach ($redirects as $redirect) {
            $this->log(
                LogLevel::INFO,
                'Import Redirect: ' . $redirect['properties']['requestPath'],
                $options
            );

            $published = Param::getBool($redirect, 'published', true);

            $publishedRedirectCmsResource = $this->upsertRedirectCmsResource->__invoke(
                new RedirectCmsResourceBasic(
                    $redirect['id'],
                    $published,
                    new RedirectVersionBasic(
                        null,
                        $redirect['properties'],
                        $createdByUserId,
                        $createdReason
                    ),
                    $createdByUserId,
                    $createdReason
                ),
                $createdByUserId,
                $createdReason
            );

            if (!$published) {
                $this->log(
                    LogLevel::WARNING,
                    'UNPUBLISH RedirectCmsResource ID: ' . $publishedRedirectCmsResource->getId(),
                    $options
                );
            }
        }
    }
}
