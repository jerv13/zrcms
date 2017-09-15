<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\CmsResourcePublishHistory;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface LayoutCmsResourcePublishHistory
    extends CmsResourcePublishHistory
{
    /**
     * @return LayoutCmsResource|CmsResource
     */
    public function getCmsResource();

    /**
     * @return LayoutVersion|ContentVersion
     */
    public function getContentVersion();
}
