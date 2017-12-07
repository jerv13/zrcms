<?php

namespace Zrcms\Cache\Api;

use Psr\SimpleCache\CacheInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetCacheValueBasic implements GetCacheValue
{
    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * @param CacheInterface $cache
     */
    public function __construct(
        CacheInterface $cache
    ) {
        $this->cache = $cache;
    }

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    public function __invoke($key, $default = null)
    {
        return $this->cache->get($key, $default);
    }
}
