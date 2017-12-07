<?php

namespace Zrcms\Core\Api\Component;

use Zrcms\Core\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindComponent
{
    /**
     * @param string $type
     * @param string $name
     * @param array  $options
     *
     * @return Component|null
     */
    public function __invoke(
        string $type,
        string $name,
        array $options = []
    );
}
