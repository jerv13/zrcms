<?php

namespace Zrcms\Cache\Api;

use Psr\SimpleCache\CacheInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ClearCacheBasic implements ClearCache
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
     * @return bool
     */
    public function __invoke(): bool
    {
        return $this->cache->clear();
    }
}
