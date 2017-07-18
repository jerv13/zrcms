<?php

namespace Zrcms\Core\Cache\Api;

use Psr\SimpleCache\CacheInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HasCacheValueBasic implements HasCacheValue
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
     *
     * @return bool
     */
    public function __invoke($key): bool
    {
        return $this->cache->has($key);
    }
}
