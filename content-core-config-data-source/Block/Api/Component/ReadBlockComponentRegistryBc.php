<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api\Component;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Api\Component\ReadComponentRegistryAbstract;
use Zrcms\ContentCore\Block\Api\Component\ReadBlockComponentConfig;
use Zrcms\ContentCore\Block\Api\Component\ReadBlockComponentConfigBc;
use Zrcms\ContentCore\Block\Api\Component\ReadBlockComponentRegistry;
use Zrcms\ContentCore\Block\Model\ServiceAliasBlock;
use Zrcms\ContentCoreConfigDataSource\Block\Model\BlockComponentRegistryFields;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @deprecated BC only
 * @author     James Jervis - https://github.com/jerv13
 */
class ReadBlockComponentRegistryBc extends ReadComponentRegistryAbstract implements ReadBlockComponentRegistry
{
    const CACHE_KEY = 'ZrcmsBlockComponentRegistryBc';

    /**
     * @var array
     */
    protected $registryConfig;

    /**
     * @param array               $registryConfig
     * @param array               $pluginConfigsBc
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param Cache               $cache
     * @param string              $cacheKey
     */
    public function __construct(
        array $registryConfig,
        array $pluginConfigsBc,
        GetServiceFromAlias $getServiceFromAlias,
        Cache $cache,
        string $cacheKey = self::CACHE_KEY
    ) {
        $registryConfig = $this->mergeRegistryConfigBc(
            $registryConfig,
            $pluginConfigsBc
        );

        parent::__construct(
            $registryConfig,
            $getServiceFromAlias,
            ServiceAliasBlock::NAMESPACE_COMPONENT_CONFIG_READER,
            $cache,
            $cacheKey,
            ReadBlockComponentConfig::class
        );
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function __invoke(
        array $options = []
    ): array
    {
        return parent::__invoke($options);
    }

    /**
     * @param array $registry
     * @param array $pluginConfigsBc
     *
     * @return array
     */
    protected function mergeRegistryConfigBc(
        array $registry,
        array $pluginConfigsBc
    ) {
        $registryBcs = [];
        foreach ($pluginConfigsBc as $name => $pluginConfigBc) {
            $registryBc = [];
            $registryBc[BlockComponentRegistryFields::COMPONENT_CONFIG_READER]
                = ReadBlockComponentConfigBc::SERVICE_ALIAS;
            $registryBc[BlockComponentRegistryFields::CONFIG_LOCATION] = $name;
            $registryBc[BlockComponentRegistryFields::NAME] = $name;
            $registryBcs[] = $registryBc;
        }

        $registry = array_merge(
            $registryBcs,
            $registry
        );

        return $registry;
    }
}
