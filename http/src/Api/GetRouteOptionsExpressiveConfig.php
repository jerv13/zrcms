<?php

namespace Zrcms\Http\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\RouteResult;
use Reliv\CacheRat\Service\Cache;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetRouteOptionsExpressiveConfig implements GetRouteOptions
{
    const CACHE_KEY = 'GetRouteOptionsExpressiveConfig';

    protected $routeConfig;
    protected $cache;
    protected $cacheKey;

    /**
     * @param array  $routeConfig
     * @param Cache  $cache
     * @param string $cacheKey
     */
    public function __construct(
        array $routeConfig,
        Cache $cache,
        string $cacheKey = self::CACHE_KEY
    ) {
        $this->routeConfig = $routeConfig;
        $this->cache = $cache;
        $this->cacheKey = $cacheKey;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return array
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function __invoke(ServerRequestInterface $request): array
    {
        /** @var RouteResult $routeResult */
        $routeResult = $request->getAttribute(RouteResult::class);
        $routeName = $routeResult->getMatchedRouteName();

        if ($this->hasCache($routeName)) {
            return $this->getCache($routeName);
        }
        $matches = array_filter(
            $this->routeConfig,
            function ($element) use ($routeName) {
                return (isset($element['name']) && $element['name'] == $routeName);
            }
        );

        if (empty($matches)) {
            throw new \Exception('No route config found for ' . $routeName);
        }

        // return first match
        $arrayValues = array_values($matches);
        $routeConfig = array_shift($arrayValues);
        $routeOptions = [];

        if (isset($routeConfig['options']) && is_array($routeConfig['options'])) {
            $routeOptions = $routeConfig['options'];
        }

        $this->setCache($routeName, $routeOptions);

        return $routeOptions;
    }

    /**
     * @param string $routeName
     *
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function hasCache(string $routeName)
    {
        $cache = $this->cache->get($this->cacheKey);

        if (empty($cache)) {
            return false;
        }

        return array_key_exists($routeName, $cache);
    }

    /**
     * @param string $routeName
     *
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function getCache(string $routeName)
    {
        if (!$this->hasCache($routeName)) {
            return null;
        }
        $cache = $this->cache->get($this->cacheKey);

        return $cache[$routeName];
    }

    /**
     * @param string $routeName
     * @param array  $routeOptions
     *
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function setCache(
        string $routeName,
        array $routeOptions
    ) {
        $cache = $this->cache->get($this->cacheKey);

        if (!is_array($cache)) {
            $cache = [];
        }

        $cache[$routeName] = $routeOptions;

        $this->cache->set($this->cacheKey, $cache);
    }
}
