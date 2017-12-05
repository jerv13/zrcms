<?php

namespace Zrcms\Content\Api\Component;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Fields\FieldsComponentConfig;
use Zrcms\Content\Fields\FieldsComponentRegistry;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ReadComponentRegistryAbstract
{
    /**
     * @var array
     */
    protected $registry;

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
    protected $cacheKey;

    /**
     * @param array               $registry
     * @param ReadComponentConfig $readComponentConfig
     * @param Cache               $cache
     * @param string              $cacheKey
     */
    public function __construct(
        array $registry,
        ReadComponentConfig $readComponentConfig,
        Cache $cache,
        string $cacheKey
    ) {
        $this->registry = $registry;
        $this->readComponentConfig = $readComponentConfig;
        $this->cache = $cache;
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
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        array $options = []
    ): array
    {
        if ($this->hasCache()) {
            return $this->getCache();
        }

        $componentConfigs = [];

        foreach ($this->registry as $componentCategory => $configLocations) {
            var_dump('CAT:', $componentCategory);
            $this->getComponentConfigs(
                $configLocations,
                $componentCategory,
                $componentConfigs
            );
        }

        $this->setCache($componentConfigs);

        return $componentConfigs;
    }

    /**
     * @param array  $configLocations
     * @param string $componentCategory
     * @param array  $componentConfigs
     *
     * @return array
     */
    protected function getComponentConfigs(
        array $configLocations,
        $componentCategory,
        &$componentConfigs = []
    ) {
        foreach ($configLocations as $componentNameOptional => $configLocation) {
            $componentConfig = $this->getComponentConfig(
                $configLocation,
                $componentCategory,
                $componentNameOptional
            );

            $componentConfigs[] = $componentConfig;
        }

        return $componentConfigs;
    }

    /**
     * @param string|array $configLocation
     * @param string       $componentCategory
     * @param string       $componentName
     *
     * @return array
     * @throws \Exception
     */
    protected function getComponentConfig(
        $configLocation,
        $componentCategory,
        $componentName
    ) {
        $componentOptions = [];

        // If the $configLocation is array, then there must be a config reader
        if (is_array($configLocation)) {
            $componentOptions = $configLocation;
            $configLocation = Param::getRequired(
                $componentOptions,
                FieldsComponentRegistry::CONFIG_LOCATION,
                new \Exception(
                    'Component location is required for: '
                    . json_encode($configLocation, 0, 2)
                    . ' in ' . $componentName
                )
            );

            $componentName = Param::get(
                $componentOptions,
                FieldsComponentRegistry::NAME,
                $componentName
            );
        }

        $componentConfig = $this->readComponentConfig->__invoke(
            $configLocation,
            $componentOptions
        );

        $componentConfigCategory = Param::get(
            $componentOptions,
            FieldsComponentConfig::CATEGORY
        );

        if ($componentConfigCategory !== $componentCategory) {
            throw new \Exception(
                'Component ' . FieldsComponentConfig::CATEGORY . ' must match registry category: '
                . ' registry value: ' . $componentCategory
                . ' config value: ' . $componentConfigCategory
            );
        }

        if (!is_string($componentName)) {
            throw new \Exception(
                'Component ' . FieldsComponentConfig::NAME . ' is required and must be string for: '
            //. json_encode($componentConfig, 0, 2)
            );
        }

        Param::assertNotHas(
            $componentConfig,
            $componentName,
            new \Exception(
                'Duplicate component name configured: ' . $componentName
            //. ' for ' . json_encode($componentConfig, 0, 2)
            )
        );

        return $componentConfig;
    }
}
