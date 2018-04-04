<?php

namespace Zrcms\Importer\Api;

use Psr\Log\LogLevel;
use Reliv\ArrayProperties\Property;
use Zrcms\CorePage\Api\CmsResource\CreatePageTemplateCmsResource;
use Zrcms\CorePage\Api\Content\InsertPageVersion;
use Zrcms\CorePage\Fields\FieldsPageVersion;
use Zrcms\CorePage\Model\PageTemplateCmsResource;
use Zrcms\CorePage\Model\PageVersionBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportPageTemplate
{
    protected $importUtilities;
    protected $insertPageVersion;
    protected $createPageTemplateCmsResource;

    public function __construct(
        ImportUtilities $importUtilities,
        InsertPageVersion $insertPageVersion,
        CreatePageTemplateCmsResource $createPageTemplateCmsResource
    ) {
        $this->importUtilities = $importUtilities;
        $this->insertPageVersion = $insertPageVersion;
        $this->createPageTemplateCmsResource = $createPageTemplateCmsResource;
    }

    /**
     * @param array  $pageTemplateData
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $options
     *
     * @return PageTemplateCmsResource|null
     * @throws \Exception
     */
    public function __invoke(
        array $pageTemplateData,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ) {
        $id = Property::getString(
            $pageTemplateData,
            'id'
        );

        $published = Property::getBool(
            $pageTemplateData,
            'published',
            true
        );

        $properties = Property::getArray(
            $pageTemplateData,
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
            'Import Page Template: ' . $path . ' SiteID: '. $siteCmsResourceId,
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

        $publishedPageTemplateCmsResource = $this->createPageTemplateCmsResource->__invoke(
            $id,
            $published,
            $version->getId(),
            $createdByUserId,
            $createdReason
        );

        if (!$published) {
            $this->importUtilities->log(
                LogLevel::WARNING,
                'UNPUBLISH PageTemplateCmsResource ID: ' . $publishedPageTemplateCmsResource->getId(),
                $options
            );
        }
        return $publishedPageTemplateCmsResource;
    }
}
