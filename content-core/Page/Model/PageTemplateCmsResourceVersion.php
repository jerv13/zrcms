<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\CmsResourceVersion;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PageTemplateCmsResourceVersion extends CmsResourceVersion
{
    /**
     * @return PageTemplateCmsResource|CmsResource
     */
    public function getCmsResource(): CmsResource;

    /**
     * NOTE: Page templates use page versions
     *
     * @return PageContainerVersion|ContentVersion
     */
    public function getVersion(): ContentVersion;
}
