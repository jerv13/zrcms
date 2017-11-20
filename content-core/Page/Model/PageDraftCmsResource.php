<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PageDraftCmsResource extends CmsResource
{
    /**
     * @return PageVersion|ContentVersion
     */
    public function getContentVersion();

    /**
     * @return string
     */
    public function getSiteCmsResourceId(): string;

    /**
     * @return string
     */
    public function getPageCmsResourceId(): string;
}
