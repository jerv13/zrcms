<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Model\CmsResourcePublishHistory;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ContainerCmsResourcePublishHistory
    extends ContainerCmsResource, CmsResourcePublishHistory
{
    /**
     * @return ContainerVersion|ContentVersion
     */
    public function getContentVersion(): ContentVersion;
}
