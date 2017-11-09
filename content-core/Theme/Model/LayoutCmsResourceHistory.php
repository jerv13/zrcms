<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\CmsResourceHistory;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface LayoutCmsResourceHistory
    extends CmsResourceHistory
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
