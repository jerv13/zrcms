<?php

namespace Zrcms\HttpRedirect\Redirect\Model;

use Zrcms\Content\Model\CmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RedirectCmsResource extends CmsResource
{
    /**
     * @return string|null
     */
    public function siteCmsResourceId();
}
