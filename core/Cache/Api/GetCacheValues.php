<?php

namespace Zrcms\Core\Cache\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetCacheValues
{
    /**
     * @param array $keys
     * @param null  $default
     *
     * @return array
     */
    public function __invoke($keys, $default = null): array;
}
