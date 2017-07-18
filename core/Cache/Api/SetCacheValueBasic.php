<?php

namespace Zrcms\Core\Cache\Api;

use Psr\SimpleCache\CacheInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class SetCacheValueBasic implements SetCacheValue
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
     * @param mixed  $value
     * @param null   $ttl
     *
     * @return bool
     */
    public function __invoke($key, $value, $ttl = null): bool
    {
        return $this->cache->set($key, $value, $ttl);
    }
}
