<?php

namespace Zrcms\ContentCoreConfigDataSource\Content\Api;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Model\Component;
use Zrcms\Content\Model\Trackable;
use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentConfigFields;
use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentRegistryFields;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class GetRegisterComponentsAbstract implements GetRegisterComponents
{
    /**
     * @var array
     */
    protected $registryConfig;

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
     * @param array               $registryConfig
     * @param ReadComponentConfig $readComponentConfig
     * @param Cache               $cache
     * @param string              $componentClass
     * @param string              $cacheKey
     */
    public function __construct(
        array $registryConfig,
        ReadComponentConfig $readComponentConfig,
        Cache $cache,
        string $componentClass,
        string $cacheKey
    ) {
        $this->registryConfig = $registryConfig;
        $this->readComponentConfig = $readComponentConfig;
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

        $componentConfigs = $this->readConfigs(
            $this->registryConfig
        );

        $configs = [];

        $componentClass = $this->componentClass;

        foreach ($componentConfigs as $componentConfig) {

            $componentConfig = $this->buildSubComponents($componentConfig);

            $configs[] = new $componentClass(
                $componentConfig,
                Param::get(
                    $componentConfig,
                    ComponentConfigFields::CREATED_BY_USER_ID,
                    Trackable::UNKNOWN_USER_ID
                ),
                Param::get(
                    $componentConfig,
                    ComponentConfigFields::CREATED_REASON,
                    Trackable::UNKNOWN_REASON
                )
            );
        }

        ddd(get_class($this),$configs);

        $this->setCache($configs);

        return $configs;
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

    /**
     * @param array $registryConfig
     *
     * @return array
     * @throws \Exception
     */
    protected function readConfigs(array $registryConfig)
    {
        $componentConfigs = [];

        foreach ($registryConfig as $componentNameOptional => $configLocation) {

            $componentOptions = [];
            $componentName = $componentNameOptional;

            if (is_array($configLocation)) {
                $componentOptions = $configLocation;
                $configLocation = Param::getRequired(
                    $componentOptions,
                    ComponentRegistryFields::CONFIG_LOCATION,
                    new \Exception(
                        'Component location is required for: ' . json_encode($configLocation)
                        . ' in ' . $this->componentClass
                    )
                );

                // @todo readComponentConfig injection here

                $componentName = Param::get(
                    $componentOptions,
                    ComponentRegistryFields::NAME,
                    $componentNameOptional
                );
            }

            $componentConfig = $this->readComponentConfig->__invoke(
                $configLocation,
                $componentOptions
            );

            if (!is_string($componentName)) {
                new \Exception(
                    'Component ' . ComponentConfigFields::NAME . ' is required and must be string for: '
                    . json_encode($componentConfig)
                    . ' in ' . $this->componentClass
                );
            }

            Param::assertNotHas(
                $componentConfig,
                $componentName,
                new \Exception(
                    'Duplicate component name configured: ' . $componentName
                    . ' for ' . $this->componentClass
                )
            );

            $componentConfigs[$componentName] = $componentConfig;
        }

        return $componentConfigs;
    }
}
