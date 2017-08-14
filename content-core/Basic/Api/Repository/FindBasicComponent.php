<?php

namespace Zrcms\ContentCore\Basic\Api\Repository;

use Zrcms\Content\Api\Repository\FindComponent;
use Zrcms\Content\Model\Component;
use Zrcms\ContentCore\Basic\Model\BasicComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindBasicComponent extends FindComponent
{
    /**
     * @param string $name
     * @param array  $options
     *
     * @return BasicComponent|Component|null
     */
    public function __invoke(
        string $name,
        array $options = []
    );
}
