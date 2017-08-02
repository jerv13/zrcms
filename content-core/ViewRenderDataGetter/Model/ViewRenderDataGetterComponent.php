<?php

namespace Zrcms\ContentCore\ViewRenderDataGetter\Model;

use Zrcms\Content\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ViewRenderDataGetterComponent extends Component
{
    /**
     * @return string
     */
    public function getViewRenderDataGetter(): string;
}
