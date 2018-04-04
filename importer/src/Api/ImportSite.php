<?php

namespace Zrcms\Importer\Api;

use Psr\Log\LogLevel;
use Reliv\ArrayProperties\Property;
use Zrcms\CoreSite\Api\CmsResource\CreateSiteCmsResource;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResource;
use Zrcms\CoreSite\Api\Content\InsertSiteVersion;
use Zrcms\CoreSite\Model\SiteCmsResource;
use Zrcms\CoreSite\Model\SiteVersionBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportSite
{
    protected $importUtilities;
    protected $findSiteCmsResource;
    protected $insertSiteVersion;
    protected $createSiteCmsResource;
    protected $importPages;
    protected $importPageTemplates;
    protected $importSiteContainers;
    protected $importRedirects;

    /**
     * @param ImportUtilities       $importUtilities
     * @param FindSiteCmsResource   $findSiteCmsResource
     * @param InsertSiteVersion     $insertSiteVersion
     * @param CreateSiteCmsResource $createSiteCmsResource
     * @param ImportPages           $importPages
     * @param ImportPageTemplates   $importPageTemplates
     * @param ImportSiteContainers  $importSiteContainers
     * @param ImportRedirects       $importRedirects
     */
    public function __construct(
        ImportUtilities $importUtilities,
        FindSiteCmsResource $findSiteCmsResource,
        InsertSiteVersion $insertSiteVersion,
        CreateSiteCmsResource $createSiteCmsResource,
        ImportPages $importPages,
        ImportPageTemplates $importPageTemplates,
        ImportSiteContainers $importSiteContainers,
        ImportRedirects $importRedirects
    ) {
        $this->importUtilities = $importUtilities;
        $this->findSiteCmsResource = $findSiteCmsResource;
        $this->insertSiteVersion = $insertSiteVersion;
        $this->createSiteCmsResource = $createSiteCmsResource;
        $this->importPages = $importPages;
        $this->importPageTemplates = $importPageTemplates;
        $this->importSiteContainers = $importSiteContainers;
        $this->importRedirects = $importRedirects;
    }

    /**
     * @param array  $siteData
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $options
     *
     * @return SiteCmsResource|null
     * @throws \Exception
     */
    public function __invoke(
        array $siteData,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ) {
        $id = Property::getString(
            $siteData,
            'id'
        );

        $published = Property::getBool(
            $siteData,
            'published',
            true
        );

        $properties = Property::getArray(
            $siteData,
            'properties',
            []
        );

        $host = Property::getRequired(
            $properties,
            'host',
            []
        );

        $pages = Property::getArray(
            $siteData,
            'pages'
        );

        $pageTemplates = Property::getArray(
            $siteData,
            'pageTemplates',
            []
        );

        $siteContainers = Property::getArray(
            $siteData,
            'siteContainers',
            []
        );

        $existing = $this->findSiteCmsResource->__invoke(
            $id
        );

        if (!empty($existing) && $this->importUtilities->skipDuplicates($options)) {
            $this->importUtilities->log(
                LogLevel::WARNING,
                'SKIP Site - Already exists: ('
                . 'siteId: ' . $id
                . ', host: ' . $host
                . ')',
                $options
            );

            return null;
        }

        $this->importUtilities->log(
            LogLevel::INFO,
            'Import Site: ('
            . 'siteId: ' . $id
            . ', host: ' . $host
            . ')',
            $options
        );

        $version = new SiteVersionBasic(
            null,
            $properties,
            $createdByUserId,
            $createdReason
        );

        $version = $this->insertSiteVersion->__invoke(
            $version
        );

        $publishedSiteCmsResource = $this->createSiteCmsResource->__invoke(
            $id,
            $published,
            $version->getId(),
            $createdByUserId,
            $createdReason
        );

        $this->importSitePages(
            $publishedSiteCmsResource,
            $pages,
            $createdByUserId,
            $createdReason,
            $options
        );

        $this->importSitePageTemplates(
            $publishedSiteCmsResource,
            $pageTemplates,
            $createdByUserId,
            $createdReason,
            $options
        );

        $this->importSiteSiteContainers(
            $publishedSiteCmsResource,
            $siteContainers,
            $createdByUserId,
            $createdReason,
            $options
        );

        if (!$published) {
            $this->importUtilities->log(
                LogLevel::WARNING,
                'UNPUBLISH SiteCmsResource ID: ' . $publishedSiteCmsResource->getId(),
                $options
            );
        }

        return $publishedSiteCmsResource;
    }

    /**
     * @param SiteCmsResource $siteCmsResource
     * @param array           $pagesData
     * @param string          $createdByUserId
     * @param string          $createdReason
     * @param array           $options
     *
     * @return array
     * @throws \Exception
     */
    protected function importSitePages(
        SiteCmsResource $siteCmsResource,
        array $pagesData,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ): array {
        if (empty($pagesData)) {
            return [];
        }
        foreach ($pagesData as $key => $pageData) {
            // @todo Force id to this site?
            $pagesData[$key]['properties']['siteCmsResourceId'] = $siteCmsResource->getId();
        }

        return $this->importPages->__invoke(
            $pagesData,
            $createdByUserId,
            $createdReason,
            $options
        );
    }

    /**
     * @param SiteCmsResource $siteCmsResource
     * @param array           $pageTemplatesData
     * @param string          $createdByUserId
     * @param string          $createdReason
     * @param array           $options
     *
     * @return array
     * @throws \Exception
     */
    protected function importSitePageTemplates(
        SiteCmsResource $siteCmsResource,
        array $pageTemplatesData,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ): array {
        if (empty($pageTemplatesData)) {
            return [];
        }
        foreach ($pageTemplatesData as $key => $pageTemplateData) {
            // @todo Force id to this site?
            $pageTemplatesData[$key]['properties']['siteCmsResourceId'] = $siteCmsResource->getId();
        }

        return $this->importPageTemplates->__invoke(
            $pageTemplatesData,
            $createdByUserId,
            $createdReason,
            $options
        );
    }

    /**
     * @param SiteCmsResource $siteCmsResource
     * @param array           $siteContainersData
     * @param string          $createdByUserId
     * @param string          $createdReason
     * @param array           $options
     *
     * @return array
     * @throws \Exception
     */
    protected function importSiteSiteContainers(
        SiteCmsResource $siteCmsResource,
        array $siteContainersData,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ): array {
        if (empty($siteContainersData)) {
            return [];
        }
        foreach ($siteContainersData as $key => $siteContainerData) {
            // @todo Force id to this site?
            $siteContainersData[$key]['properties']['siteCmsResourceId'] = $siteCmsResource->getId();
        }

        return $this->importSiteContainers->__invoke(
            $siteContainersData,
            $createdByUserId,
            $createdReason,
            $options
        );
    }
}
