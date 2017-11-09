<?php

namespace Zrcms\ContentCore\Site\Model;

use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface SiteVersion extends Site, ContentVersion
{
    /**
     * @return string
     */
    public function getHost(): string;
}
