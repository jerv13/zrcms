<?php

namespace Zrcms\ContentCore\Site\Model;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface SiteCmsResource extends CmsResource
{
    /**
     * @return SiteVersion|ContentVersion
     */
    public function getContentVersion(): ContentVersion;

    /**
     * @return string
     */
    public function getHost(): string;
}
