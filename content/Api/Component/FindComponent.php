<?php

namespace Zrcms\Content\Api\Component;

use Zrcms\Content\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindComponent
{
    /**
     * @param string $name
     * @param array  $options
     *
     * @return Component|null
     */
    public function __invoke(
        string $name,
        array $options = []
    );
}