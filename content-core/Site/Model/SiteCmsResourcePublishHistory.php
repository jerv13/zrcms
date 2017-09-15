<?php

namespace Zrcms\ContentCore\Site\Model;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\CmsResourcePublishHistory;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface SiteCmsResourcePublishHistory
    extends CmsResourcePublishHistory
{
    /**
     * @return SiteCmsResource|CmsResource
     */
    public function getCmsResource();

    /**
     * @return SiteVersion|ContentVersion
     */
    public function getContentVersion();
}
