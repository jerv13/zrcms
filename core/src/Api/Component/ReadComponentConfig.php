<?php

namespace Zrcms\Core\Api\Component;

use Zrcms\Core\Exception\CanNotReadComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ReadComponentConfig
{
    /**
     * @param string $componentConfigUri (directory or location)
     * @param array  $options
     *
     * @return array
     * @throws CanNotReadComponentConfig
     */
    public function __invoke(
        string $componentConfigUri,
        array $options = []
    ): array;
}
