<?php

namespace Zrcms\CoreView\Api;

use Reliv\CacheRat\Service\Cache;
use Zrcms\CoreTheme\Model\Layout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetTagNamesByLayoutMustache implements GetTagNamesByLayout
{
    const CACHE_KEY = 'GetTagNamesByLayoutMustache';
    const CACHE_TTL = 30;

    protected $cache;
    protected $cacheKey;
    protected $cacheTtl;

    /**
     * @param Cache  $cache
     * @param string $cacheKey
     * @param int    $cacheTtl
     */
    public function __construct(
        Cache $cache,
        string $cacheKey = self::CACHE_KEY,
        int $cacheTtl = self::CACHE_TTL
    ) {
        $this->cache = $cache;
        $this->cacheKey = $cacheKey;
        $this->cacheTtl = $cacheTtl;
    }

    /**
     * @param Layout $layout
     * @param array  $options
     *
     * @return string[] ['{container-name}']
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function __invoke(
        Layout $layout,
        array $options = []
    ): array {
        if ($this->hasCache($layout->getId())) {
            return $this->getCache($layout->getId());
        }

        // '/\{\{' . PropertiesContainer::RENDER_NAMESPACE . '.([^}:]+)\}\}/'
        preg_match_all(
            '/\{\{([^{^}:]+)\}\}/',
            $layout->getHtml(),
            $matches
        );

        $this->setCache($layout->getId(), $matches[1]);

        return $matches[1];
    }

    /**
     * @param string $layoutId
     *
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function hasCache(string $layoutId)
    {
        $cache = $this->cache->get($this->cacheKey);

        if (empty($cache)) {
            return false;
        }

        return array_key_exists($layoutId, $cache);
    }

    /**
     * @param string $layoutId
     *
     * @return string[]|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function getCache(string $layoutId)
    {
        if (!$this->hasCache($layoutId)) {
            return null;
        }

        $cache = $this->cache->get($this->cacheKey);

        return $cache[$layoutId];
    }

    /**
     * @param string $layoutId
     * @param string[] ['{container-name}']
     *
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function setCache(
        string $layoutId,
        array $layoutTags
    ) {
        $cache = $this->cache->get($this->cacheKey);

        if (!is_array($cache)) {
            $cache = [];
        }

        $cache[$layoutId] = $layoutTags;

        $this->cache->set($this->cacheKey, $cache, $this->cacheTtl);
    }
}
