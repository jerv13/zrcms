<?php

namespace Zrcms\Importer\Api;

use Psr\Log\LogLevel;
use Reliv\ArrayProperties\Property;
use Zrcms\CoreContainer\Model\ContainerVersionBasic;
use Zrcms\CoreSiteContainer\Api\CmsResource\CreateSiteContainerCmsResource;
use Zrcms\CoreSiteContainer\Api\Content\InsertSiteContainerVersion;
use Zrcms\CoreSiteContainer\Model\SiteContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportSiteContainer
{
    protected $importUtilities;
    protected $insertSiteContainerVersion;
    protected $createSiteContainerCmsResource;

    /**
     * @param ImportUtilities                $importUtilities
     * @param InsertSiteContainerVersion     $insertSiteContainerVersion
     * @param CreateSiteContainerCmsResource $createSiteContainerCmsResource
     */
    public function __construct(
        ImportUtilities $importUtilities,
        InsertSiteContainerVersion $insertSiteContainerVersion,
        CreateSiteContainerCmsResource $createSiteContainerCmsResource
    ) {
        $this->importUtilities = $importUtilities;
        $this->insertSiteContainerVersion = $insertSiteContainerVersion;
        $this->createSiteContainerCmsResource = $createSiteContainerCmsResource;
    }

    /**
     * @param array  $siteDataContainer
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $options
     *
     * @return SiteContainerCmsResource|null
     * @throws \Exception
     */
    public function __invoke(
        array $siteDataContainer,
        string $createdByUserId,
        string $createdReason,
        array $options = []
    ) {
        $id = Property::getString(
            $siteDataContainer,
            'id'
        );

        $published = Property::getBool(
            $siteDataContainer,
            'published',
            true
        );

        $properties = Property::getArray(
            $siteDataContainer,
            'properties',
            []
        );

        $siteCmsResourceId = Property::getRequired(
            $properties,
            'siteCmsResourceId'
        );

        $name = Property::getRequired(
            $properties,
            'name'
        );

        $this->importUtilities->log(
            LogLevel::INFO,
            'Import Container: ' . $name . ' SiteID: ' . $siteCmsResourceId,
            $options
        );

        $version = new ContainerVersionBasic(
            null,
            $properties,
            $createdByUserId,
            $createdReason
        );

        $version = $this->insertSiteContainerVersion->__invoke(
            $version
        );

        $publishedContainerCmsResource = $this->createSiteContainerCmsResource->__invoke(
            $id,
            $published,
            $version->getId(),
            $createdByUserId,
            $createdReason
        );

        if (!$published) {
            $this->importUtilities->log(
                LogLevel::WARNING,
                'UNPUBLISH ContainerCmsResource ID: ' . $publishedContainerCmsResource->getId(),
                $options
            );
        }

        return $publishedContainerCmsResource;
    }
}
