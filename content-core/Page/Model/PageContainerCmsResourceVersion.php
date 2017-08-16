<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\CmsResourceVersion;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PageContainerCmsResourceVersion extends CmsResourceVersion
{
    /**
     * @return PageContainerCmsResource|CmsResource
     */
    public function getCmsResource(): CmsResource;

    /**
     * @return PageContainerVersion|ContentVersion
     */
    public function getVersion(): ContentVersion;
}
