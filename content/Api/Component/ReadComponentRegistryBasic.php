<?php

namespace Zrcms\Content\Api\Component;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Fields\FieldsComponentConfig;
use Zrcms\Content\Fields\FieldsComponentRegistry;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentRegistryBasic implements ReadComponentRegistry
{
    const CACHE_KEY = 'ZrcmsComponentRegistryBasic';
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

        foreach ($this->registry as $index => $registryEntry) {
            $componentConfig = $this->getComponentConfig(
                $registryEntry
            );

            $componentConfigs[] = $componentConfig;
        }

        $this->assertNoDuplicateNames($componentConfigs);

        $this->setCache($componentConfigs);

        return $componentConfigs;
    }

    /**
     * @param array $registryEntry
     *
     * @return array
     * @throws \Exception
     */
    protected function getComponentConfig(
        array $registryEntry
    ) {
        $componentType = Param::get(
            $registryEntry,
            FieldsComponentRegistry::TYPE,
            FieldsComponentRegistry::DEFAULT_TYPE
        );

        $componentName = Param::getRequired(
            $registryEntry,
            FieldsComponentRegistry::NAME
        );

        $this->assertValidName($componentName);

        $configLocation = Param::getRequired(
            $registryEntry,
            FieldsComponentRegistry::CONFIG_LOCATION,
            new \Exception(
                'Component location is required for: '
                . json_encode($registryEntry, 0, 2)
                . ' in ' . $componentName
            )
        );

        /**
         * @todo This is a bit of a hack
         */
        $componentReaderOptions = $registryEntry;

        $componentConfig = $this->readComponentConfig->__invoke(
            $configLocation,
            $componentReaderOptions
        );

        $componentConfigType = Param::get(
            $componentConfig,
            FieldsComponentConfig::TYPE,
            $componentType
        );

        if ($componentConfigType !== $componentType) {
            throw new \Exception(
                'Component ' . FieldsComponentConfig::TYPE . ' must match registry type: '
                . ' for component: (' . $componentName . ')'
                . ' registry value: (' . $componentType . ')'
                . ' config value: (' . $componentConfigType . ')'
            );
        }

        // Back-fill if value is not set
        $componentConfig[FieldsComponentConfig::TYPE] = $componentConfigType;

        return $componentConfig;
    }

    /**
     * @param $componentName
     *
     * @return void
     * @throws \Exception
     */
    protected function assertValidName($componentName)
    {
        if (!is_string($componentName)) {
            throw new \Exception(
                'Component ' . FieldsComponentConfig::NAME . ' is required and must be string for: '
            //. json_encode($componentConfig, 0, 2)
            );
        }
    }

    /**
     * @param array $componentConfigs
     *
     * @return void
     */
    protected function assertNoDuplicateNames(
        array $componentConfigs
    ) {
        $uniqueIndex = [];

        foreach ($componentConfigs as $componentConfig) {
            $name = Param::getRequired(
                $componentConfig,
                FieldsComponentConfig::NAME
            );
            $type = Param::getRequired(
                $componentConfig,
                FieldsComponentConfig::TYPE
            );

            $unique = $type . '.' . $name;

            if (in_array($unique, $uniqueIndex)) {
                new \Exception(
                    'Duplicate component name configured'
                    . ' with type: (' . $type . ')'
                    . ' and name: (' . $name . ')'
                //. ' for ' . json_encode($componentConfig, 0, 2)
                );
            }

            $uniqueIndex[] = $unique;
        }
    }
}
