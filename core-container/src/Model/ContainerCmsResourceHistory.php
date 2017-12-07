<?php

namespace Zrcms\CoreContainer\Model;

use Zrcms\Core\Model\CmsResource;
use Zrcms\Core\Model\CmsResourceHistory;
use Zrcms\Core\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ContainerCmsResourceHistory extends CmsResourceHistory
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
