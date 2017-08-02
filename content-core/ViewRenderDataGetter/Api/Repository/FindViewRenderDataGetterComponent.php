<?php

namespace Zrcms\ContentCore\ViewRenderDataGetter\Api\Repository;

use Zrcms\Content\Api\Repository\FindComponent;
use Zrcms\Content\Model\Component;
use Zrcms\ContentCore\ViewRenderDataGetter\Model\ViewRenderDataGetterComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindViewRenderDataGetterComponent extends FindComponent
{
    /**
     * @param string $name
     * @param array  $options
     *
     * @return ViewRenderDataGetterComponent|Component|null
     */
    public function __invoke(
        string $name,
        array $options = []
    );
}
