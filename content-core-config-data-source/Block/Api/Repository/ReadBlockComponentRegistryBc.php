<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api\Repository;

use Zrcms\Content\Api\Repository\ReadComponentRegistryAbstract;
use Zrcms\ContentCore\Block\Api\PrepareBlockConfigBc;
use Zrcms\ContentCore\Block\Api\Repository\ReadBlockComponentConfig;
use Zrcms\ContentCore\Block\Api\Repository\ReadBlockComponentConfigBasic;
use Zrcms\ContentCore\Block\Api\Repository\ReadBlockComponentConfigBc;
use Zrcms\ContentCore\Block\Api\Repository\ReadBlockComponentConfigJsonFile;
use Zrcms\ContentCore\Block\Api\Repository\ReadBlockComponentRegistry;
use Zrcms\ContentCore\Block\Model\ServiceAliasBlock;
use Zrcms\ContentCoreConfigDataSource\Block\Model\BlockComponentRegistryFields;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @deprecated BC only
 * @author James Jervis - https://github.com/jerv13
 */
class ReadBlockComponentRegistryBc extends ReadComponentRegistryAbstract implements ReadBlockComponentRegistry
{
    /**
     * @var array
     */
    protected $registryConfig;

    /**
     * @param array               $registryConfig
     * @param array               $pluginConfigsBc
     * @param GetServiceFromAlias $getServiceFromAlias
     */
    public function __construct(
        array $registryConfig,
        array $pluginConfigsBc,
        GetServiceFromAlias $getServiceFromAlias
    ) {
        $registryConfig = $this->mergeRegistryConfigBc(
            $registryConfig,
            $pluginConfigsBc
        );

        parent::__construct(
            $registryConfig,
            $getServiceFromAlias,
            ServiceAliasBlock::NAMESPACE_COMPONENT_CONFIG_READER,
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
        foreach ($pluginConfigsBc as $name => $pluginConfigBc) {
            $pluginConfigBc[BlockComponentRegistryFields::COMPONENT_CONFIG_READER] = ReadBlockComponentConfigBc::SERVICE_ALIAS;
            $pluginConfigBc[BlockComponentRegistryFields::CONFIG_LOCATION] = $name;
            $pluginConfigsBc[$name] = $pluginConfigBc;
        }

        $registry = array_merge(
            $pluginConfigsBc,
            $registry
        );

        return $registry;
    }
}
