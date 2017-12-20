<?php

namespace Zrcms\Mustache\Resolver;

use Phly\Mustache\Resolver\ResolverInterface;
use Zrcms\Cache\Service\Cache;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FileResolver implements ResolverInterface
{
    const DEFAULT_CACHE_KEY = 'ZrcmsMustacheFileResolver';

    protected $cache;
    protected $cacheKey;

    /**
     * @param Cache  $cache
     * @param string $cacheKey
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function __construct(
        Cache $cache,
        string $cacheKey = self::DEFAULT_CACHE_KEY
    ) {
        $this->cache = $cache;
        $this->cacheKey = $cacheKey;
        $this->cache->set($this->cacheKey, []);
    }

    /**
     * @param string $templatePath
     *
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function hasCache(string $templatePath)
    {
        $cache = $this->cache->get($this->cacheKey);

        return array_key_exists($templatePath, $cache);
    }

    /**
     * @param string $templatePath
     *
     * @return null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function getCache(string $templatePath)
    {
        if (!$this->hasCache($templatePath)) {
            return null;
        }
        $cache = $this->cache->get($this->cacheKey);

        return $cache[$templatePath];
    }

    /**
     * @param string $templatePath
     * @param        $template
     *
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function setCache(string $templatePath, $template)
    {
        $cache = $this->cache->get($this->cacheKey);

        $cache[$templatePath] = $template;

        $this->cache->set($this->cacheKey, $cache);
    }

    /**
     * Resolve a template name to mustache content or a set of tokens.
     *
     * @param string $templatePath
     *
     * @return array|bool|null|string
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function resolve($templatePath)
    {
        $templatePathReal = realpath($templatePath);

        if ($templatePathReal === false) {
            throw new \Exception(
                'Template file does not exist: ' . $templatePath
            );
        }

        if ($this->hasCache($templatePathReal)) {
            return $this->getCache($templatePathReal);
        }

        $template = file_get_contents(
            $templatePathReal
        );

        $this->setCache($templatePathReal, $template);

        return $template;
    }
}
