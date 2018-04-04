<?php

namespace Zrcms\Importer\Api;

use Psr\Log\LogLevel;
use Reliv\ArrayProperties\Property;
use Zrcms\CorePage\Api\CmsResource\CreatePageCmsResource;
use Zrcms\CorePage\Api\Content\InsertPageVersion;
use Zrcms\CorePage\Model\PageCmsResource;
use Zrcms\CorePage\Model\PageVersionBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportPage
{
    protected $importOptions;
    protected $insertPageVersion;
    protected $createPageCmsResource;

    /**
     * @param ImportOptions         $importOptions
     * @param InsertPageVersion     $insertPageVersion
     * @param CreatePageCmsResource $createPageCmsResource
     */
    public function __construct(
        ImportOptions $importOptions,
        InsertPageVersion $insertPageVersion,
        CreatePageCmsResource $createPageCmsResource
    ) {
        $this->importOptions = $importOptions;
        $this->insertPageVersion = $insertPageVersion;
        $this->createPageCmsResource = $createPageCmsResource;
    }

    /**
     * @param array  $pageData
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $options
     *
     * @return PageCmsResource|null
     * @throws \Exception
     */
    public function __invoke(
        array $pageData,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ) {
        $id = Property::getString(
            $pageData,
            'id'
        );

        $published = Property::getBool(
            $pageData,
            'published',
            true
        );

        $properties = Property::getArray(
            $pageData,
            'properties',
            []
        );

        $siteCmsResourceId = Property::getRequired(
            $properties,
            'siteCmsResourceId'
        );

        $path = Property::getRequired(
            $properties,
            'path'
        );

        $this->importOptions->log(
            LogLevel::INFO,
            'Import Page: ' . $path . ' ID: ' . $id . ' SiteID: ' . $siteCmsResourceId,
            $options
        );

        $version = new PageVersionBasic(
            null,
            $properties,
            $createdByUserId,
            $createdReason
        );

        $version = $this->insertPageVersion->__invoke(
            $version
        );

        $publishedPageCmsResource = $this->createPageCmsResource->__invoke(
            $id,
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

        return $publishedPageCmsResource;
    }
}
