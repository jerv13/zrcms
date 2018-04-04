<?php

namespace Zrcms\Importer\Api;

use Psr\Log\LogLevel;
use Reliv\ArrayProperties\Property;
use Reliv\Json\Json;
use Zrcms\CoreContainer\Fields\FieldsContainerVersion;
use Zrcms\CoreContainer\Model\ContainerVersionBasic;
use Zrcms\CorePage\Api\CmsResource\CreatePageCmsResource;
use Zrcms\CorePage\Api\CmsResource\CreatePageTemplateCmsResource;
use Zrcms\CorePage\Api\Content\InsertPageVersion;
use Zrcms\CorePage\Fields\FieldsPageVersion;
use Zrcms\CorePage\Model\PageVersionBasic;
use Zrcms\CoreRedirect\Api\CmsResource\CreateRedirectCmsResource;
use Zrcms\CoreRedirect\Api\CmsResource\FindRedirectCmsResource;
use Zrcms\CoreRedirect\Api\Content\InsertRedirectVersion;
use Zrcms\CoreRedirect\Model\RedirectVersionBasic;
use Zrcms\CoreSite\Api\CmsResource\CreateSiteCmsResource;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResource;
use Zrcms\CoreSite\Api\Content\InsertSiteVersion;
use Zrcms\CoreSite\Model\SiteCmsResource;
use Zrcms\CoreSite\Model\SiteVersionBasic;
use Zrcms\CoreSiteContainer\Api\CmsResource\CreateSiteContainerCmsResource;
use Zrcms\CoreSiteContainer\Api\Content\InsertSiteContainerVersion;

class Import
{
    protected $importOptions;
    protected $findSiteCmsResource;
    protected $insertSiteVersion;
    protected $createSiteCmsResource;
    protected $insertPageVersion;
    protected $createPageCmsResource;
    protected $createPageTemplateCmsResource;
    protected $insertSiteContainerVersion;
    protected $createSiteContainerCmsResource;
    protected $findRedirectCmsResource;
    protected $insertRedirectVersion;
    protected $createRedirectCmsResource;

    /**
     * @param ImportUtilities                $importOptions
     * @param FindSiteCmsResource            $findSiteCmsResource
     * @param InsertSiteVersion              $insertSiteVersion
     * @param CreateSiteCmsResource          $createSiteCmsResource
     * @param InsertPageVersion              $insertPageVersion
     * @param CreatePageCmsResource          $createPageCmsResource
     * @param CreatePageTemplateCmsResource  $createPageTemplateCmsResource
     * @param InsertSiteContainerVersion     $insertSiteContainerVersion
     * @param CreateSiteContainerCmsResource $createSiteContainerCmsResource
     * @param FindRedirectCmsResource        $findRedirectCmsResource
     * @param InsertRedirectVersion          $insertRedirectVersion
     * @param CreateRedirectCmsResource      $createRedirectCmsResource
     */
    public function __construct(
        ImportUtilities $importOptions,
        FindSiteCmsResource $findSiteCmsResource,
        InsertSiteVersion $insertSiteVersion,
        CreateSiteCmsResource $createSiteCmsResource,
        InsertPageVersion $insertPageVersion,
        CreatePageCmsResource $createPageCmsResource,
        CreatePageTemplateCmsResource $createPageTemplateCmsResource,
        InsertSiteContainerVersion $insertSiteContainerVersion,
        CreateSiteContainerCmsResource $createSiteContainerCmsResource,
        FindRedirectCmsResource $findRedirectCmsResource,
        InsertRedirectVersion $insertRedirectVersion,
        CreateRedirectCmsResource $createRedirectCmsResource
    ) {
        $this->importOptions = $importOptions;
        $this->findSiteCmsResource = $findSiteCmsResource;
        $this->insertSiteVersion = $insertSiteVersion;
        $this->createSiteCmsResource = $createSiteCmsResource;
        $this->insertPageVersion = $insertPageVersion;
        $this->createPageCmsResource = $createPageCmsResource;
        $this->createPageTemplateCmsResource = $createPageTemplateCmsResource;
        $this->insertSiteContainerVersion = $insertSiteContainerVersion;
        $this->createSiteContainerCmsResource = $createSiteContainerCmsResource;
        $this->findRedirectCmsResource = $findRedirectCmsResource;
        $this->insertRedirectVersion = $insertRedirectVersion;
        $this->createRedirectCmsResource = $createRedirectCmsResource;
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

        $data = Json::decode(
            $json,
            true
        );

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

        $this->importOptions->log(
            LogLevel::INFO,
            'Import COMPLETE in ' . (time() - $startTime) . ' seconds',
            $options
        );
    }

    /**
     * @param array  $data
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $options
     *
     * @return void
     * @throws \Zrcms\Core\Exception\CmsResourceExists
     * @throws \Zrcms\Core\Exception\CmsResourceNotExists
     * @throws \Zrcms\Core\Exception\ContentVersionNotExists
     */
    protected function createSites(
        array $data,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ) {
        $this->importOptions->log(
            LogLevel::INFO,
            'Import Sites:',
            $options
        );

        foreach ($data['sites'] as $site) {
            $existing = $this->findSiteCmsResource->__invoke(
                $site['id']
            );

            if (!empty($existing) && $this->importOptions->skipDuplicates($options)) {
                $this->importOptions->log(
                    LogLevel::WARNING,
                    'SKIP Site - Already exists: ('
                    . 'siteId: ' . $site['id']
                    . ', host: ' . $site['properties']['host']
                    . ')',
                    $options
                );
                continue;
            }

            $this->importOptions->log(
                LogLevel::INFO,
                'Import Site: ('
                . 'siteId: ' . $site['id']
                . ', host: ' . $site['properties']['host']
                . ')',
                $options
            );

            $published = Property::getBool($site, 'published', true);

            $version = new SiteVersionBasic(
                null,
                $site['properties'],
                $createdByUserId,
                $createdReason
            );

            $version = $this->insertSiteVersion->__invoke(
                $version
            );

            $publishedSiteCmsResource = $this->createSiteCmsResource->__invoke(
                $site['id'],
                $published,
                $version->getId(),
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
                $this->importOptions->log(
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
     * @throws \Zrcms\Core\Exception\CmsResourceExists
     * @throws \Zrcms\Core\Exception\ContentVersionNotExists
     */
    protected function createPages(
        SiteCmsResource $siteCmsResource,
        array $pages,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ) {
        $this->importOptions->log(
            LogLevel::INFO,
            'Import Pages: ('
            . 'siteId: ' . $siteCmsResource->getId()
            . ')',
            $options
        );

        foreach ($pages as $page) {
            $this->importOptions->log(
                LogLevel::INFO,
                'Import Page: ' . $page['properties']['path'] . ' ID: ' . $page['id'],
                $options
            );

            $page['properties'][FieldsPageVersion::SITE_CMS_RESOURCE_ID] = $siteCmsResource->getId();

            $published = Property::getBool($page, 'published', true);

            $version = new PageVersionBasic(
                null,
                $page['properties'],
                $createdByUserId,
                $createdReason
            );

            $version = $this->insertPageVersion->__invoke(
                $version
            );

            $publishedPageCmsResource = $this->createPageCmsResource->__invoke(
                $page['id'],
                $published,
                $version->getId(),
                $createdByUserId,
                $createdReason
            );

            if (!$published) {
                $this->importOptions->log(
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
     * @throws \Zrcms\Core\Exception\CmsResourceExists
     * @throws \Zrcms\Core\Exception\ContentVersionNotExists
     */
    protected function createPageTemplates(
        SiteCmsResource $siteCmsResource,
        array $pageTemplates,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ) {
        $this->importOptions->log(
            LogLevel::INFO,
            'Import Page Templates: ('
            . 'siteId: ' . $siteCmsResource->getId()
            . ')',
            $options
        );

        foreach ($pageTemplates as $pageTemplate) {
            $this->importOptions->log(
                LogLevel::INFO,
                'Import Page Template: ' . $pageTemplate['properties']['path'],
                $options
            );

            $pageTemplate['properties'][FieldsPageVersion::SITE_CMS_RESOURCE_ID] = $siteCmsResource->getId();

            $published = Property::getBool($pageTemplate, 'published', true);

            $version = new PageVersionBasic(
                null,
                $pageTemplate['properties'],
                $createdByUserId,
                $createdReason
            );

            $version = $this->insertPageVersion->__invoke(
                $version
            );

            $publishedPageTemplateCmsResource = $this->createPageTemplateCmsResource->__invoke(
                $pageTemplate['id'],
                $published,
                $version->getId(),
                $createdByUserId,
                $createdReason
            );

            if (!$published) {
                $this->importOptions->log(
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
     * @throws \Zrcms\Core\Exception\CmsResourceExists
     * @throws \Zrcms\Core\Exception\ContentVersionNotExists
     */
    protected function createContainers(
        SiteCmsResource $siteCmsResource,
        array $containers,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ) {
        $this->importOptions->log(
            LogLevel::INFO,
            'Import Containers: ('
            . 'siteId: ' . $siteCmsResource->getId()
            . ')',
            $options
        );

        foreach ($containers as $container) {
            $this->importOptions->log(
                LogLevel::INFO,
                'Import Container: ' . $container['properties']['name'],
                $options
            );

            $container['properties'][FieldsContainerVersion::SITE_CMS_RESOURCE_ID] = $siteCmsResource->getId();

            $published = Property::getBool($container, 'published', true);

            $version = new ContainerVersionBasic(
                null,
                $container['properties'],
                $createdByUserId,
                $createdReason
            );

            $version = $this->insertSiteContainerVersion->__invoke(
                $version
            );

            $publishedContainerCmsResource = $this->createSiteContainerCmsResource->__invoke(
                $container['id'],
                $published,
                $version->getId(),
                $createdByUserId,
                $createdReason
            );

            if (!$published) {
                $this->importOptions->log(
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
     * @throws \Zrcms\Core\Exception\CmsResourceExists
     * @throws \Zrcms\Core\Exception\ContentVersionNotExists
     */
    protected function createRedirects(
        array $redirects,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ) {
        $this->importOptions->log(
            LogLevel::INFO,
            'Import Redirects: ',
            $options
        );

        foreach ($redirects as $redirect) {
            $existing = $this->findRedirectCmsResource->__invoke(
                $redirect['id']
            );

            if (!empty($existing) && $this->importOptions->skipDuplicates($options)) {
                $this->importOptions->log(
                    LogLevel::WARNING,
                    'SKIP redirect - Already exists: ('
                    . 'redirect Id: ' . $redirect['id']
                    . ')',
                    $options
                );
                continue;
            }

            $this->importOptions->log(
                LogLevel::INFO,
                'Import Redirect: ' . $redirect['properties']['requestPath'],
                $options
            );

            $published = Property::getBool($redirect, 'published', true);

            $version = new RedirectVersionBasic(
                null,
                $redirect['properties'],
                $createdByUserId,
                $createdReason
            );

            $version = $this->insertRedirectVersion->__invoke(
                $version
            );

            $publishedRedirectCmsResource = $this->createRedirectCmsResource->__invoke(
                $redirect['id'],
                $published,
                $version->getId(),
                $createdByUserId,
                $createdReason
            );

            if (!$published) {
                $this->importOptions->log(
                    LogLevel::WARNING,
                    'UNPUBLISH RedirectCmsResource ID: ' . $publishedRedirectCmsResource->getId(),
                    $options
                );
            }
        }
    }
}
