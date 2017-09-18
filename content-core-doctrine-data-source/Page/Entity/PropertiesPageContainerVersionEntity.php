<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Entity;

use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\FieldsContainerVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesPageContainerVersionEntity extends FieldsContainerVersionEntity
{
    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::ID => '',
            self::RENDER_TAGS_GETTER => '',
            self::RENDERER => '',
            self::BLOCK_VERSIONS => [],
        ];
}
