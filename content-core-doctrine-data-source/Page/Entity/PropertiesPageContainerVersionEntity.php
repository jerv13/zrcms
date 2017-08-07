<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Entity;

use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\PropertiesContainerVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesPageContainerVersionEntity extends PropertiesContainerVersionEntity
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
