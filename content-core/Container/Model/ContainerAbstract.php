<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Model\ContentAbstract;
use Zrcms\ContentCore\Container\Api\BuildBlockVersions;
use Zrcms\ContentCore\Container\Fields\FieldsContainer;
use Zrcms\Param\Param;

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
        $blockVersions = Param::getArray(
            $properties,
            FieldsContainer::BLOCK_VERSIONS,
            []
        );

        $properties[FieldsContainer::BLOCK_VERSIONS] = BuildBlockVersions::prepare(
            $blockVersions
        );

        parent::__construct($properties);
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
