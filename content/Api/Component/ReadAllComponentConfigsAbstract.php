<?php

namespace Zrcms\Content\Api\Component;

use Psr\Container\ContainerInterface;
use Zrcms\Cache\Service\Cache;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ReadAllComponentConfigsAbstract
{
    const CACHE_KEY = 'ZrcmsReadAllComponentConfigs';

    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var array
     */
    protected $readComponentRegistryServices;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var string
     */
    protected $cacheKey;

    /**
     * @param ContainerInterface $serviceContainer
     * @param array              $readComponentRegistryServices
     * @param Cache              $cache
     * @param string             $cacheKey
     */
    public function __construct(
        $serviceContainer,
        array $readComponentRegistryServices,
        Cache $cache,
        string $cacheKey = self::CACHE_KEY
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->readComponentRegistryServices = $readComponentRegistryServices;
        $this->cache = $cache;
        $this->cacheKey = $cacheKey;
    }

    /**
     * Return a name spaced list of all component configs
     *
     * @param array $options
     *
     * @return array
     */
    public function __invoke(
        array $options = []
    ): array
    {
        $cached = $this->cache->get($this->cacheKey);

        if (!empty($cached)) {
            return $cached;
        }
        $result = [];

        foreach ($this->readComponentRegistryServices as $componentCategory => $readComponentRegistryServiceName) {
            /** @var ReadComponentRegistry $service */
            $service = $this->serviceContainer->get($readComponentRegistryServiceName);
            $result[$componentCategory] = $service->__invoke();
        }

        $this->cache->set($this->cacheKey, $result);

        return $result;
    }
}
