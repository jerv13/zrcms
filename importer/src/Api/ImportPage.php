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
    protected $importUtilities;
    protected $insertPageVersion;
    protected $createPageCmsResource;

    /**
     * @param ImportUtilities       $importUtilities
     * @param InsertPageVersion     $insertPageVersion
     * @param CreatePageCmsResource $createPageCmsResource
     */
    public function __construct(
        ImportUtilities $importUtilities,
        InsertPageVersion $insertPageVersion,
        CreatePageCmsResource $createPageCmsResource
    ) {
        $this->importUtilities = $importUtilities;
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

        $this->importUtilities->log(
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
            $this->importUtilities->log(
                LogLevel::WARNING,
                'UNPUBLISH PageCmsResource ID: ' . $publishedPageCmsResource->getId(),
                $options
            );
        }

        return $publishedPageCmsResource;
    }
}
