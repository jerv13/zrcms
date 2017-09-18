<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\CmsResourcePublishHistory;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ContainerCmsResourcePublishHistory extends CmsResourcePublishHistory
{
    /**
     * @return ContainerCmsResource|CmsResource
     */
    public function getCmsResource();

    /**
     * @return ContainerVersion|ContentVersion
     */
    public function getContentVersion();
}
