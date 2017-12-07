<?php

namespace Zrcms\CoreRedirect\Model;

use Zrcms\Core\Model\CmsResource;
use Zrcms\Core\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RedirectCmsResource extends CmsResource
{
    /**
     * @return RedirectVersion|ContentVersion
     */
    public function getContentVersion();

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
}
