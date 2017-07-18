<?php

namespace Zrcms\Core\Cache\Api;

use Psr\SimpleCache\CacheInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetCacheValuesBasic implements GetCacheValues
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
     * @param null  $default
     *
     * @return array
     */
    public function __invoke($keys, $default = null): array
    {
        return $this->cache->getMultiple($keys, $default);
    }
}
