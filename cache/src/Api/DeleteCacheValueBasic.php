<?php

namespace Zrcms\Cache\Api;

use Psr\SimpleCache\CacheInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class DeleteCacheValueBasic implements DeleteCacheValue
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
        return $this->cache->delete($key);
    }
}
