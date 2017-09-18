<?php

namespace Zrcms\Content\Api\Component;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Fields\FieldsComponentConfig;
use Zrcms\ContentCoreConfigDataSource\Content\Fields\FieldsComponentRegistry;
use Zrcms\Param\Param;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ReadComponentRegistryAbstract implements ReadComponentRegistry
{
    /**
     * @var array
     */
    protected $registry;

    /**
     * @var GetServiceFromAlias
     */
    protected $getServiceFromAlias;

    /**
     * @var string
     */
    protected $serviceAliasNamespace;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var string
     */
    protected $cacheKey;

    /**
     * @var string
     */
    protected $defaultComponentConfReaderServiceAlias;

    /**
     * @param array               $registry
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $serviceAliasNamespace
     * @param Cache               $cache
     * @param string              $cacheKey
     * @param string              $defaultComponentConfReaderServiceAlias
     */
    public function __construct(
        array $registry,
        GetServiceFromAlias $getServiceFromAlias,
        string $serviceAliasNamespace,
        Cache $cache,
        string $cacheKey,
        string $defaultComponentConfReaderServiceAlias = ReadComponentConfig::class
    ) {
        $this->registry = $registry;
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = $serviceAliasNamespace;
        $this->cache = $cache;
        $this->cacheKey = $cacheKey;
        $this->defaultComponentConfReaderServiceAlias = $defaultComponentConfReaderServiceAlias;
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

        foreach ($this->registry as $componentNameOptional => $configLocation) {

            $componentOptions = [];
            $componentName = $componentNameOptional;

            $readComponentConfigServiceAlias = $this->defaultComponentConfReaderServiceAlias;

            if (is_array($configLocation)) {
                $componentOptions = $configLocation;
                $configLocation = Param::getRequired(
                    $componentOptions,
                    FieldsComponentRegistry::CONFIG_LOCATION,
                    new \Exception(
                        'Component location is required for: ' //. json_encode($configLocation, 0, 2)
                        . ' in ' . $componentName
                    )
                );

                $readComponentConfigServiceAlias = Param::get(
                    $componentOptions,
                    FieldsComponentRegistry::COMPONENT_CONFIG_READER,
                    ''
                );

                $componentName = Param::get(
                    $componentOptions,
                    FieldsComponentRegistry::NAME,
                    $componentNameOptional
                );
            }

            /** @var ReadComponentConfig $readComponentConfig */
            $readComponentConfig = $this->getServiceFromAlias->__invoke(
                $this->serviceAliasNamespace,
                $readComponentConfigServiceAlias,
                ReadComponentConfig::class,
                $this->defaultComponentConfReaderServiceAlias
            );

            $componentConfig = $readComponentConfig->__invoke(
                $configLocation,
                $componentOptions
            );

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

            $componentConfigs[$componentName] = $componentConfig;
        }

        $this->setCache($componentConfigs);

        return $componentConfigs;
    }
}
