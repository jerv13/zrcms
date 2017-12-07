<?php

namespace Zrcms\Cache\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface SetCacheValues
{
    /**
     * @param array $values
     * @param null  $ttl
     *
     * @return bool
     */
    public function __invoke(array $values, $ttl = null): bool;
}
