<?php

namespace Zrcms\CoreContainer\Model;

use Zrcms\Core\Exception\PropertyInvalid;
use Zrcms\Core\Model\ContentAbstract;
use Zrcms\CoreBlock\Model\BlockVersion;
use Zrcms\CoreContainer\Api\BuildBlockVersion;
use Zrcms\CoreContainer\Api\BuildBlockVersions;
use Zrcms\CoreContainer\Api\PrepareBlockVersionsData;
use Zrcms\CoreContainer\Fields\FieldsContainer;
use Zrcms\CoreApplication\Api\GetGuidV4;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContainerAbstract extends ContentAbstract
{
    /**
     * @param array $properties
     */
    public function __construct(array $properties)
    {
        $blockVersions = Property::getArray(
            $properties,
            FieldsContainer::BLOCK_VERSIONS,
            []
        );

        $id = GetGuidV4::invoke();

        $properties[FieldsContainer::BLOCK_VERSIONS] = PrepareBlockVersionsData::invoke(
            $blockVersions,
            $id
        );

        parent::__construct($properties, $id);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->findProperty(
            FieldsContainer::NAME
        );
    }

    /**
     * @return string
     */
    public function getContext(): string
    {
        return $this->findProperty(
            FieldsContainer::CONTEXT
        );
    }


    /**
     * @return BlockVersion[]
     */
    public function getBlockVersions(): array
    {
        $blockVersions = $this->findProperty(
            FieldsContainer::BLOCK_VERSIONS,
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
     * @param string $id
     *
     * @return BlockVersion|null
     */
    public function findBlockVersion(string $id)
    {
        $blockVersionsData = $this->findProperty(
            FieldsContainer::BLOCK_VERSIONS,
            []
        );

        /** @var ContainerVersion $containerVersion */
        $containerVersion = $this;

        foreach ($blockVersionsData as $blockVersionData) {
            if ($blockVersionData['id'] == $id) {
                return BuildBlockVersion::invoke(
                    $containerVersion,
                    $blockVersionData
                );
            }
        }

        return null;
    }
}
