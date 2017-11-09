<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\CmsResourceHistory;
use Zrcms\Content\Model\ContentVersion;

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
