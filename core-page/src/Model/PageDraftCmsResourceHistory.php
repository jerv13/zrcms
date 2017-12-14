<?php

namespace Zrcms\CorePage\Model;

use Zrcms\Core\Model\CmsResource;
use Zrcms\Core\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PageDraftCmsResourceHistory extends PageCmsResourceHistory
{
    /**
     * @return PageDraftCmsResource|CmsResource
     */
    public function getCmsResource();

    /**
     * @return PageVersion|ContentVersion
     */
    public function getContentVersion();
}
