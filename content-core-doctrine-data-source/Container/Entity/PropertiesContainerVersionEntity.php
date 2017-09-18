<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Container\Entity;

use Zrcms\ContentCore\Container\Fields\FieldsContainer;
use Zrcms\ContentCore\Container\Fields\FieldsContainerVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsContainerVersionEntity extends FieldsContainerVersion
{
    const BLOCK_VERSIONS = FieldsContainer::BLOCK_VERSIONS;

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::RENDER_TAGS_GETTER => '',
            self::RENDERER => '',
            self::BLOCK_VERSIONS => [],
        ];
}
