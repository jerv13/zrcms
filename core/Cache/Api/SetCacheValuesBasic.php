<?php

namespace Zrcms\Core\Cache\Api;

use Psr\SimpleCache\CacheInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class SetCacheValuesBasic implements SetCacheValues
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
     * @param array $values
     * @param null  $ttl
     *
     * @return bool
     */
    public function __invoke(array $values, $ttl = null): bool
    {
        return $this->cache->setMultiple($values, $ttl);
    }
}
