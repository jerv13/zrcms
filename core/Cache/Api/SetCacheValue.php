<?php

namespace Zrcms\Core\Cache\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface SetCacheValue
{
    /**
     * @param string $key
     * @param mixed  $value
     * @param null   $ttl
     *
     * @return bool
     */
    public function __invoke($key, $value, $ttl = null): bool;
}
