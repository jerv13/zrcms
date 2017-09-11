<?php

namespace Zrcms\ContentRedirect\Model;

use Zrcms\Content\Model\CmsResourcePublishHistory;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RedirectCmsResourcePublishHistory
    extends RedirectCmsResource, CmsResourcePublishHistory
{
    /**
     * @return RedirectVersion|ContentVersion
     */
    public function getContentVersion(): ContentVersion;
}
