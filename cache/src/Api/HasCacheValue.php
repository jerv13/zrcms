<?php

namespace Zrcms\Cache\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface HasCacheValue
{
    /**
     * @param string $key
     *
     * @return bool
     */
    public function __invoke($key): bool;
}
