<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Container\Model\ContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PageContainerCmsResource extends ContainerCmsResource
{
    /**
     * @return PageContainerVersion|ContentVersion
     */
    public function getContentVersion();
}
