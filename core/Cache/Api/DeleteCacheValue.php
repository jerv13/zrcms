<?php

namespace Zrcms\Core\Cache\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface DeleteCacheValue
{
    /**
     * @param string $key
     *
     * @return bool
     */
    public function __invoke($key): bool;
}
