<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface LayoutCmsResource extends CmsResource
{
    /**
     * @return LayoutVersion|ContentVersion
     */
    public function getContentVersion(): ContentVersion;

    /**
     * @return string
     */
    public function getThemeName(): string;

    /**
     * @return string
     */
    public function getName(): string;
}
