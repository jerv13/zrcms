<?php

namespace Zrcms\CorePage\Model;

use Zrcms\Core\Model\CmsResource;
use Zrcms\Core\Model\CmsResourceHistory;
use Zrcms\Core\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PageCmsResourceHistory
    extends CmsResourceHistory
{
    /**
     * @return PageCmsResource|CmsResource
     */
    public function getCmsResource();

    /**
     * @return PageVersion|ContentVersion
     */
    public function getContentVersion();
}
