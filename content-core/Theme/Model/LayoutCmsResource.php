<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Model\CmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface LayoutCmsResource extends CmsResource
{
    /**
     * @return string
     */
    public function getThemeName(): string;

    /**
     * @return string
     */
    public function getName(): string;
}
