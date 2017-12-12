<?php

namespace Zrcms\CoreApplication\Api\Component;

use Zrcms\Cache\Service\Cache;
use Zrcms\Cache\Service\CacheArray;
use Zrcms\Core\Api\Component\BuildComponentObject;
use Zrcms\Core\Api\Component\GetRegisterComponents;
use Zrcms\Core\Api\Component\ReadComponentConfigs;
use Zrcms\Core\Model\Component;

/**
 * @todo This should not be needed
 * @author James Jervis - https://github.com/jerv13
 */
class GetRegisterComponentsBasic implements GetRegisterComponents
{
    const CACHE_KEY = 'ZrcmsComponentConfigBasic';

    /**
     * @var ReadComponentConfigs
     */
    protected $readComponentConfigs;

    /**
     * @var BuildComponentObject
     */
    protected $buildComponentObject;

    /**
     * @todo Note: This cache is storing objects
     *
     * @var Cache
     */
    protected $cache;

    /**
     * @var string
     */
    protected $cacheKey;

    /**
     * @param ReadComponentConfigs $readComponentConfigs
     * @param BuildComponentObject $buildComponentObject
     * @param CacheArray           $cache
     * @param string               $cacheKey
     */
    public function __construct(
        ReadComponentConfigs $readComponentConfigs,
        BuildComponentObject $buildComponentObject,
        CacheArray $cache,
        string $cacheKey = self::CACHE_KEY
    ) {
        $this->readComponentConfigs = $readComponentConfigs;
        $this->buildComponentObject = $buildComponentObject;
        $this->cache = $cache;
        $this->cacheKey = $cacheKey;
    }

    /**
     * @param array $options
     *
     * @return Component[]
     */
    public function __invoke(
        array $options = []
    ): array {
        if ($this->hasCache()) {
            return $this->getCache();
        }

        $componentConfigs = $this->readComponentConfigs->__invoke();

        $configs = $this->buildComponentObjects(
            $componentConfigs
        );

        $this->setCache($configs);

        return $configs;
    }

    /**
     * @param array $componentConfigs
     *
     * @return Component[]
     */
    protected function buildComponentObjects(
        array $componentConfigs
    ) {
        $configs = [];
        foreach ($componentConfigs as $componentConfig) {
            $configs[] = $this->buildComponentObject->__invoke(
                $componentConfig
            );
        }

        return $configs;
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
}
