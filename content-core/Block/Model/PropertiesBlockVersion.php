<?php

namespace Zrcms\ContentCore\Block\Model;

use Zrcms\Content\Model\PropertiesContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PropertiesBlockVersion extends PropertiesBlock, PropertiesContentVersion
{
    const BLOCK_CONTAINER_CMS_RESOURCE_ID = 'blockContainerCmsResourceId';
}
