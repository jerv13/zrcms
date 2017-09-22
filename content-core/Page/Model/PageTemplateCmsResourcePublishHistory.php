<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PageTemplateCmsResourcePublishHistory
    extends PageContainerCmsResourcePublishHistory
{
    /**
     * @return PageTemplateCmsResource|CmsResource
     */
    public function getCmsResource();

    /**
     * @return PageContainerVersion|ContentVersion
     */
    public function getContentVersion();
}
