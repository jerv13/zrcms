<?php

namespace Zrcms\ContentCore\View\Api\Repository;

use Zrcms\Content\Api\Repository\FindComponent;
use Zrcms\Content\Model\Component;
use Zrcms\ContentCore\View\Model\ViewComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindViewComponent extends FindComponent
{
    /**
     * @param string $name
     * @param array  $options
     *
     * @return ViewComponent|Component|null
     */
    public function __invoke(
        string $name,
        array $options = []
    );
}
