<?php

namespace Zrcms\Core\Cache\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetCacheValue
{
    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    public function __invoke($key, $default = null);
}
