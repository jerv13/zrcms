<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PageTemplateCmsResourcePublishHistory
    extends PageCmsResourcePublishHistory
{
    /**
     * @return PageTemplateCmsResource|CmsResource
     */
    public function getCmsResource();

    /**
     * @return PageVersion|ContentVersion
     */
    public function getContentVersion();
}
