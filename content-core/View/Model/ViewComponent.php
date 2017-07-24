<?php

namespace Zrcms\ContentCore\View\Model;

use Zrcms\Content\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ViewComponent extends Component
{
    const DEFAULT_NAME = 'default';

    /**
     * @return array
     */
    public function getViewRenderDataGetters(): array;
}
