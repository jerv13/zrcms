<?php

namespace Zrcms\ContentRedirect\Model;

use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RedirectVersion extends ContentVersion
{
    /**
     * @return string
     */
    public function getRedirectPath(): string;
}
