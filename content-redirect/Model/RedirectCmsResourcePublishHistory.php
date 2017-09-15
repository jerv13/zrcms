<?php

namespace Zrcms\ContentRedirect\Model;

use Zrcms\Content\Model\CmsResourcePublishHistory;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RedirectCmsResourcePublishHistory
    extends CmsResourcePublishHistory
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
