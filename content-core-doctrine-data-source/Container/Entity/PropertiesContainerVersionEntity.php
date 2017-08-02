<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Container\Entity;

use Zrcms\ContentCore\Container\Model\PropertiesContainerVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesContainerVersionEntity extends PropertiesContainerVersion
{
    const BLOCK_VERSIONS_DATA = 'blockVersionsData';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::ID => '',
            self::RENDER_DATA_GETTER => '',
            self::RENDERER => '',
            self::BLOCK_VERSIONS_DATA => [],
        ];
}
