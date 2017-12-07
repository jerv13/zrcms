<?php

namespace Zrcms\CoreView\Model;

use Zrcms\Core\Model\Component;

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
