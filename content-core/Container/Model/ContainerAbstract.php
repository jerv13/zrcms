<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Exception\PropertyInvalid;
use Zrcms\Content\Model\ContentAbstract;
use Zrcms\ContentCore\Container\Api\BuildBlockVersions;
use Zrcms\ContentCore\Container\Api\PrepareBlockVersionsData;
use Zrcms\ContentCore\Container\Fields\FieldsContainer;
use Zrcms\ContentCore\GetGuidV4;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContainerAbstract extends ContentAbstract
{
    /**
     * @param array $properties
     *
     * @throws PropertyInvalid
     */
    public function __construct(array $properties)
    {
        $blockVersions = Param::getArray(
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
     * @return array
     */
    public function getBlockVersions(): array
    {
        $blockVersions = $this->getProperty(
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
}
