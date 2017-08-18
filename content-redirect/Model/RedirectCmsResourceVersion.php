<?php

namespace Zrcms\ContentRedirect\Model;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\CmsResourceVersion;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RedirectCmsResourceVersion extends CmsResourceVersion
{
    /**
     * @return RedirectCmsResource|CmsResource
     */
    public function getCmsResource(): CmsResource;

    /**
     * @return RedirectVersion|ContentVersion
     */
    public function getVersion(): ContentVersion;
}
