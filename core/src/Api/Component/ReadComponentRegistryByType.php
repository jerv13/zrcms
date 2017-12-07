<?php

namespace Zrcms\Core\Api\Component;

use Psr\Container\ContainerInterface;
use Zrcms\Cache\Service\Cache;
use Zrcms\Core\Api\GetTypeValue;
use Zrcms\Core\Fields\FieldsComponentConfig;
use Zrcms\Core\Fields\FieldsComponentRegistry;
use Zrcms\Core\Model\ServiceAliasComponent;
use Zrcms\Param\Param;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentRegistryByType implements ReadComponentRegistry
{
    const CACHE_KEY = 'ZrcmsComponentRegistryBasic';

    protected $serviceContainer;
    protected $registry;
    protected $getTypeValue;
    protected $getServiceFromAlias;
    protected $cache;
    protected $cacheKey;
    protected $configReaderServiceAliasNamespace;
    protected $defaultReadComponentConfigServiceName;
    protected $defaultPrepareComponentConfig;

    /**
     * @todo Throw more specific exceptions
     *
     * @param ContainerInterface  $serviceContainer
     * @param array               $registry
     * @param GetTypeValue        $getTypeValue
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param Cache               $cache
     * @param string              $cacheKey
     * @param string              $configReaderServiceAliasNamespace
     * @param string              $defaultReadComponentConfigServiceName
     * @param string              $defaultPrepareComponentConfig
     */
    public function __construct(
        $serviceContainer,
        array $registry,
        GetTypeValue $getTypeValue,
        GetServiceFromAlias $getServiceFromAlias,
        Cache $cache,
        string $cacheKey = self::CACHE_KEY,
        string $configReaderServiceAliasNamespace = ServiceAliasComponent::ZRCMS_COMPONENT_CONFIG_READER,
        string $defaultReadComponentConfigServiceName = ReadComponentConfigJsonFile::class,
        string $defaultPrepareComponentConfig = PrepareComponentConfigNoop::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->registry = $registry;
        
        $this->getTypeValue = $getTypeValue;
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->cache = $cache;
        $this->cacheKey = $cacheKey;
        $this->configReaderServiceAliasNamespace = $configReaderServiceAliasNamespace;
        $this->defaultReadComponentConfigServiceName = $defaultReadComponentConfigServiceName;
        $this->defaultPrepareComponentConfig = $defaultPrepareComponentConfig;
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
    ): array {
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

        $configModuleDirectory = Param::getRequired(
            $registryEntry,
            FieldsComponentRegistry::MODULE_DIRECTORY,
            new \Exception(
                'Component module directory is required for: '
                . json_encode($registryEntry, 0, 2)
                . ' in ' . $componentName
            )
        );

        $registryEntryReadComponentConfigAlias = Param::get(
            $registryEntry,
            FieldsComponentRegistry::COMPONENT_CONFIG_READER,
            ''
        );

        $defaultReadComponentConfigServiceName = $this->getTypeValue->__invoke(
            $componentType,
            ReadComponentConfig::class,
            $this->defaultReadComponentConfigServiceName
        );

        /** @var ReadComponentConfig $readComponentConfig */
        $readComponentConfig = $this->getServiceFromAlias->__invoke(
            $this->configReaderServiceAliasNamespace,
            $registryEntryReadComponentConfigAlias,
            ReadComponentConfig::class,
            $defaultReadComponentConfigServiceName
        );

        $componentConfig = $readComponentConfig->__invoke(
            $configLocation
        );

        $componentConfigType = Param::get(
            $componentConfig,
            FieldsComponentConfig::TYPE,
            $componentType
        );

        if ($componentConfigType !== $componentType) {
            throw new \Exception(
                'Component type must match registry type: '
                . ' for component: (' . $componentName . ')'
                . ' registry value: (' . $componentType . ')'
                . ' config value: (' . $componentConfigType . ')'
            );
        }

        // Back-fill if value is not set
        $componentConfig[FieldsComponentConfig::TYPE] = $componentConfigType;
        $componentConfig[FieldsComponentConfig::MODULE_DIRECTORY] = $configModuleDirectory;

        $prepareComponentConfigServiceName = $this->getTypeValue->__invoke(
            $componentConfigType,
            PrepareComponentConfig::class,
            $this->defaultPrepareComponentConfig
        );

        /** @var PrepareComponentConfig $prepareComponentConfig */
        $prepareComponentConfig = $this->serviceContainer->get($prepareComponentConfigServiceName);

        $this->assertValidPrepareComponentConfig($prepareComponentConfig);

        $componentConfig = $prepareComponentConfig->__invoke(
            $componentConfig
        );

        return $componentConfig;
    }

    /**
     * @param $prepareComponentConfig
     *
     * @return void
     * @throws \Exception
     */
    protected function assertValidPrepareComponentConfig($prepareComponentConfig)
    {
        if (!is_a($prepareComponentConfig, PrepareComponentConfig::class)) {
            throw new \Exception(
                'PrepareComponentConfig is not valid: '
                . $prepareComponentConfig . ' must be a ' . PrepareComponentConfig::class
            );
        }
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
