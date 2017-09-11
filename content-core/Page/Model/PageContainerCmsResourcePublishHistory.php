<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\Content\Model\CmsResourcePublishHistory;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PageContainerCmsResourcePublishHistory
    extends PageContainerCmsResource, CmsResourcePublishHistory
{
    /**
     * @return PageContainerVersion|ContentVersion
     */
    public function getContentVersion();
}
