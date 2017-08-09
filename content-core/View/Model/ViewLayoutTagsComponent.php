<?php

namespace Zrcms\ContentCore\View\Model;

use Zrcms\Content\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ViewLayoutTagsComponent extends Component
{
    /**
     * @return string
     */
    public function getViewLayoutTagsGetter(): string;
}
