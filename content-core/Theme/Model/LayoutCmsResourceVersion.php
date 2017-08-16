<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\CmsResourceVersion;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface LayoutCmsResourceVersion extends CmsResourceVersion
{
    /**
     * @return LayoutCmsResource|CmsResource
     */
    public function getCmsResource(): CmsResource;

    /**
     * @return LayoutVersion|ContentVersion
     */
    public function getVersion(): ContentVersion;
}
