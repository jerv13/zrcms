<?php

namespace Zrcms\ContentCore\ViewLayoutTags\Model;

use Zrcms\Content\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ViewLayoutTagsGetterComponent extends Component
{
    /**
     * @return string
     */
    public function getViewRenderTagsGetter(): string;
}
