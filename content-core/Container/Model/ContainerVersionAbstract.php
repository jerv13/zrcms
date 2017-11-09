<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Exception\PropertyInvalid;
use Zrcms\Content\Model\ContentVersionAbstract;
use Zrcms\ContentCore\Container\Api\BuildBlockVersions;
use Zrcms\ContentCore\Container\Api\PrepareBlockVersionsData;
use Zrcms\ContentCore\Container\Fields\FieldsContainerVersion;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContainerVersionAbstract extends ContentVersionAbstract
{
    /**
     * @param null|string $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        string $createdDate = null
    ) {
        $blockVersions = Param::getArray(
            $properties,
            FieldsContainerVersion::BLOCK_VERSIONS,
            []
        );

        $properties[FieldsContainerVersion::BLOCK_VERSIONS] = PrepareBlockVersionsData::invoke(
            $blockVersions,
            $id
        );

        Param::assertNotEmpty(
            $properties,
            FieldsContainerVersion::SITE_CMS_RESOURCE_ID
        );

        Param::assertNotEmpty(
            $properties,
            FieldsContainerVersion::PATH
        );

        parent::__construct(
            $id,
            $properties,
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }

    /**
     * @return array
     */
    public function getBlockVersions(): array
    {
        $blockVersions = $this->getProperty(
            FieldsContainerVersion::BLOCK_VERSIONS,
            []
        );

        /** @var ContainerVersion $containerVersion */
        $containerVersion = $this;

        return BuildBlockVersions::invoke(
            $containerVersion,
            $blockVersions
        );
    }

    /**
     * @return string
     */
    public function getSiteCmsResourceId(): string
    {
        return $this->getProperty(
            FieldsContainerVersion::SITE_CMS_RESOURCE_ID
        );
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->getProperty(
            FieldsContainerVersion::PATH
        );
    }
}
