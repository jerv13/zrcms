<?php

namespace Zrcms\ContentCore\Site\Model;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\CmsResourceVersion;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface SiteCmsResourceVersion extends CmsResourceVersion
{
    /**
     * @return SiteCmsResource|CmsResource
     */
    public function getCmsResource(): CmsResource;

    /**
     * @return SiteVersion|ContentVersion
     */
    public function getVersion(): ContentVersion;
}
