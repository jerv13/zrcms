<?php

namespace Zrcms\Content\Api;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Api\Repository\ReadComponentRegistry;
use Zrcms\Content\Model\Component;
use Zrcms\Content\Model\ComponentConfigFields;
use Zrcms\Content\Model\Trackable;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class GetRegisterComponentsAbstract implements GetRegisterComponents
{
    /**
     * @var
     */
    protected $readComponentRegistry;

    /**
     * @var ReadComponentConfig
     */
    protected $readComponentConfig;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var string
     */
    protected $componentClass;

    /**
     * @var string
     */
    protected $cacheKey;

    /**
     * @param ReadComponentRegistry $readComponentRegistry
     * @param Cache                 $cache
     * @param string                $componentClass
     * @param string                $cacheKey
     */
    public function __construct(
        ReadComponentRegistry $readComponentRegistry,
        Cache $cache,
        string $componentClass,
        string $cacheKey
    ) {
        $this->readComponentRegistry = $readComponentRegistry;
        $this->cache = $cache;
        $this->componentClass = $componentClass;
        $this->cacheKey = $cacheKey;
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
     * @param array $options
     *
     * @return Component[]
     */
    public function __invoke(
        array $options = []
    ): array
    {
        if ($this->hasCache()) {
            return $this->getCache();
        }

        $componentConfigs = $this->readComponentRegistry->__invoke();

        $configs = [];

        $componentClass = $this->componentClass;

        foreach ($componentConfigs as $componentConfig) {

            $preparedConfig = $this->prepareConfig($componentConfig);
            $builtConfig = $this->buildSubComponents($preparedConfig);

            $configs[] = new $componentClass(
                $builtConfig,
                Param::get(
                    $builtConfig,
                    ComponentConfigFields::CREATED_BY_USER_ID,
                    Trackable::UNKNOWN_USER_ID
                ),
                Param::get(
                    $builtConfig,
                    ComponentConfigFields::CREATED_REASON,
                    Trackable::UNKNOWN_REASON
                )
            );
        }

        $this->setCache($configs);

        return $configs;
    }

    /**
     * @param array $componentConfig
     *
     * @return array
     */
    protected function prepareConfig(array $componentConfig): array
    {
        // over-ride to prepare config
        return $componentConfig;
    }

    /**
     * @param array $componentConfig
     *
     * @return array
     */
    protected function buildSubComponents(array $componentConfig): array
    {
        // over-ride to build sub-components
        return $componentConfig;
    }
}
