<?php

namespace Zrcms\CoreApplication\Api\Component;

use Psr\Container\ContainerInterface;
use Zrcms\Cache\Service\Cache;
use Zrcms\Core\Api\Component\ReadComponentRegistry;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentRegistryComposite implements ReadComponentRegistry
{
    const DEFAULT_CACHE_KEY = 'ZrcmsReadComponentRegistryComposite';

    protected $serviceLocator;
    protected $readComponentRegistryServiceNames;
    protected $cache;
    protected $cacheKey;

    /**
     * @param ContainerInterface $serviceLocator
     * @param array              $readComponentRegistryServiceNames
     * @param Cache              $cache
     * @param string             $cacheKey
     */
    public function __construct(
        $serviceLocator,
        array $readComponentRegistryServiceNames,
        Cache $cache,
        string $cacheKey = self::DEFAULT_CACHE_KEY
    ) {
        $this->serviceLocator = $serviceLocator;
        $this->readComponentRegistryServiceNames = $readComponentRegistryServiceNames;
        $this->cache = $cache;
        $this->cacheKey = $cacheKey;
    }

    public function __invoke(
        array $options = []
    ): array {
        if ($this->hasCache()) {
            return $this->getCache();
        }

        $componentRegistry = [];

        foreach ($this->readComponentRegistryServiceNames as $readComponentRegistryServiceName) {
            /** @var ReadComponentRegistry $readComponentRegistry */
            $readComponentRegistry = $this->serviceLocator->get($readComponentRegistryServiceName);
            $componentRegistryMore = $readComponentRegistry->__invoke($options);

            $componentRegistry = array_merge(
                $componentRegistry,
                $componentRegistryMore
            );
        }

        $this->setCache($componentRegistry);

        return $componentRegistry;
    }

    /**
     * hasCache
     *
     * @return bool
     */
    protected function hasCache()
    {
        return ($this->cache->has($this->cacheKey));
    }

    /**
     * getCache
     *
     * @return mixed
     */
    protected function getCache()
    {
        return $this->cache->get($this->cacheKey);
    }

    /**
     * setCache
     *
     * @param array $configs
     *
     * @return void
     */
    protected function setCache($configs)
    {
        $this->cache->set($this->cacheKey, $configs);
    }

    /**
     * @param array $componentRegistry
     *
     * @return void
     * @throws \Exception
     */
    protected function assertNoNumericIndexes(
        array $componentRegistry
    ) {
        foreach ($componentRegistry as $index => $componentRegistryEntry) {
            if(is_numeric($index)) {
                throw new \Exception(
                    'Component registry keys must be "{componentType}.{componentType}"'
                    . ' for: ' . $componentRegistryEntry
                );
            }
        }
    }
}
