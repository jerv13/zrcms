<?php

namespace Zrcms\ContentRedirect\Model;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\CmsResourceHistory;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RedirectCmsResourceHistory
    extends CmsResourceHistory
{
    /**
     * @return RedirectCmsResource|CmsResource
     */
    public function getCmsResource();

    /**
     * @return RedirectVersion|ContentVersion
     */
    public function getContentVersion();
}
