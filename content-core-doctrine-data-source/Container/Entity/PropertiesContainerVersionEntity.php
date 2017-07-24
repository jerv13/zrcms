<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Container\Entity;

use Zrcms\Content\Model\TrackableProperties;
use Zrcms\ContentCore\Container\Model\PropertiesContainerVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PropertiesContainerVersionEntity extends PropertiesContainerVersion
{
    const BLOCK_VERSIONS_DATA = 'blockVersionsData';
}
