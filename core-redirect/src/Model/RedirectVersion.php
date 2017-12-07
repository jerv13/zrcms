<?php

namespace Zrcms\CoreRedirect\Model;

use Zrcms\Core\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RedirectVersion extends ContentVersion
{
    /**
     * if string, then applies to that site
     * if null, then applies to ALL sites
     *
     * @return string|null
     */
    public function getSiteCmsResourceId();

    /**
     * @return string
     */
    public function getRequestPath(): string;

    /**
     * @return string
     */
    public function getRedirectPath(): string;
}
