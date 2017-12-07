<?php

namespace Zrcms\Cache\Api;

use Psr\SimpleCache\CacheInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class DeleteCacheValuesBasic implements DeleteCacheValues
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
     * @param array $keys
     *
     * @return bool
     */
    public function __invoke(array $keys): bool
    {
        return $this->cache->deleteMultiple($keys);
    }
}
