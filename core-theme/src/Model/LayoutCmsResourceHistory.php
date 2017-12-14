<?php

namespace Zrcms\CoreTheme\Model;

use Zrcms\Core\Model\CmsResource;
use Zrcms\Core\Model\CmsResourceHistory;
use Zrcms\Core\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface LayoutCmsResourceHistory extends CmsResourceHistory
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
