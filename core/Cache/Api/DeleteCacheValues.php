<?php

namespace Zrcms\Core\Cache\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface DeleteCacheValues
{
    /**
     * @param array $keys
     *
     * @return bool
     */
    public function __invoke(array $keys): bool;
}
