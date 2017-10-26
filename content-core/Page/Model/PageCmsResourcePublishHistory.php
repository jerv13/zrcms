<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\CmsResourcePublishHistory;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PageCmsResourcePublishHistory
    extends CmsResourcePublishHistory
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
