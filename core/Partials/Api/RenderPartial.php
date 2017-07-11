<?php

namespace Zrcms\Core\Partial\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderPartial
{
    /**
     * @param array $params
     * @param array $options
     *
     * @return array
     */
    public function __invoke(
        array $params = [],
        array $options = []
    ): array;
}
