<?php

namespace Zrcms\CoreApplication\Api\Component;

use Zrcms\Cache\Service\Cache;
use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\Core\Api\Component\ReadComponentConfigs;
use Zrcms\Core\Api\Component\ReadComponentRegistry;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigsBasic implements ReadComponentConfigs
{
    const DEFAULT_CACHE_KEY = 'ZrcmsReadComponentConfigsBasic';

    protected $readComponentRegistry;
    protected $readComponentConfig;
    protected $cache;
    protected $cacheKey;

    /**
     * @param ReadComponentRegistry $readComponentRegistry
     * @param ReadComponentConfig   $readComponentConfig
     * @param Cache                 $cache
     * @param string                $cacheKey
     */
    public function __construct(
        ReadComponentRegistry $readComponentRegistry,
        ReadComponentConfig $readComponentConfig,
        Cache $cache,
        string $cacheKey = self::DEFAULT_CACHE_KEY
    ) {
        $this->readComponentRegistry = $readComponentRegistry;
        $this->readComponentConfig = $readComponentConfig;
        $this->cache = $cache;
        $this->cacheKey = $cacheKey;
    }

    /**
     * @param array $options
     *
     * @return array
     * @throws \Zrcms\Core\Exception\CanNotReadComponentConfig
     */
    public function __invoke(
        array $options = []
    ): array {
        if ($this->hasCache()) {
            return $this->getCache();
        }
        $componentConfigs = [];
        $namespaceIndex = [];
        $componentRegistry = $this->readComponentRegistry->__invoke();

        foreach ($componentRegistry as $namespace => $componentConfigUri) {
            if (in_array($namespace, $namespaceIndex)) {
                new \Exception(
                    'Duplicate component namespace configured: (' . $namespace . ')'
                    //. ' for ' . json_encode($componentConfig, 0, 2)
                );
            }
            $namespaceIndex[] = $namespace;

            $componentConfig = $this->readComponentConfig->__invoke($componentConfigUri);

            $componentConfigs[] = $componentConfig;
        }

        $this->setCache($componentConfigs);

        return $componentConfigs;
    }

    /**
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function hasCache()
    {
        return ($this->cache->has($this->cacheKey));
    }

    /**
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function getCache()
    {
        return $this->cache->get($this->cacheKey);
    }

    /**
     * @param $configs
     *
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function setCache($configs)
    {
        $this->cache->set($this->cacheKey, $configs);
    }
}
