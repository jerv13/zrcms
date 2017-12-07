<?php

namespace Zrcms\CoreApplication\Api\Component;

use Zrcms\Cache\Service\Cache;
use Zrcms\Core\Api\Component\BuildComponentObject;
use Zrcms\Core\Api\Component\GetRegisterComponents;
use Zrcms\Core\Api\Component\ReadComponentRegistry;
use Zrcms\Core\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetRegisterComponentsBasic implements GetRegisterComponents
{
    const CACHE_KEY = 'ZrcmsComponentConfigBasic';

    /**
     * @var ReadComponentRegistry
     */
    protected $readComponentRegistry;

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
     * @param ReadComponentRegistry $readComponentRegistry
     * @param BuildComponentObject  $buildComponentObject
     * @param Cache                 $cache
     * @param string                $cacheKey
     */
    public function __construct(
        ReadComponentRegistry $readComponentRegistry,
        BuildComponentObject $buildComponentObject,
        Cache $cache,
        string $cacheKey = self::CACHE_KEY
    ) {
        $this->readComponentRegistry = $readComponentRegistry;
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

        $componentRegistry = $this->readComponentRegistry->__invoke();

        $configs = $this->buildComponentObjects(
            $componentRegistry
        );

        $this->setCache($configs);

        return $configs;
    }

    /**
     * @param array $componentRegistry
     *
     * @return Component[]
     */
    protected function buildComponentObjects(
        array $componentRegistry
    ) {
        $configs = [];
        foreach ($componentRegistry as $componentConfig) {
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
