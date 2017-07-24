<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Model\Trackable;
use Zrcms\ContentCore\Block\Model\BlockComponent;
use Zrcms\ContentCore\Block\Model\BlockComponentBasic;
use Zrcms\ContentCoreConfigDataSource\Block\Model\BlockComponentConfigFields;
use Zrcms\ContentCoreConfigDataSource\Content\Api\GetConfigComponentsAbstract;
use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentConfigFields;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetConfigBlockComponentsBc extends GetConfigComponentsAbstract implements GetConfigBlockComponents
{
    const CACHE_KEY = 'ZrcmsBlockComponentConfigBc';
    /**
     * @var array
     */
    protected $registryConfig;

    /**
     * @var PrepareBlockConfig
     */
    protected $prepareBlockConfig;

    /**
     * @param array                    $registryConfig
     * @param array                    $pluginConfigsBc
     * @param ReadBlockComponentConfig $readBlockComponentConfig
     * @param Cache                    $cache
     * @param PrepareBlockConfig       $prepareBlockConfig
     * @param string                   $componentClass
     * @param string                   $cacheKey
     */
    public function __construct(
        array $registryConfig,
        array $pluginConfigsBc,
        ReadBlockComponentConfig $readBlockComponentConfig,
        Cache $cache,
        PrepareBlockConfig $prepareBlockConfig,
        string $componentClass = BlockComponentBasic::class,
        string $cacheKey = self::CACHE_KEY
    ) {
        $this->prepareBlockConfig = $prepareBlockConfig;

        $registryConfig = $this->mergeRegistryConfigBc(
            $registryConfig,
            $pluginConfigsBc
        );

        parent::__construct(
            $registryConfig,
            $readBlockComponentConfig,
            $cache,
            $componentClass,
            $cacheKey
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
        if ($this->hasCache()) {
            return $this->getCache();
        }

        $blockComponentConfigs = $this->readConfigs(
            $this->registryConfig
        );

        $configs = [];

        $componentClass = $this->componentClass;

        foreach ($blockComponentConfigs as $blockComponentConfig) {
            $blockComponentConfig = $this->prepareBlockConfig->__invoke(
                $blockComponentConfig
            );

            $configs[] = new $componentClass(
                $blockComponentConfig,
                Param::get(
                    $blockComponentConfig,
                    ComponentConfigFields::CREATED_BY_USER_ID,
                    Trackable::UNKNOWN_USER_ID
                ),
                Param::get(
                    $blockComponentConfig,
                    ComponentConfigFields::CREATED_REASON,
                    Trackable::UNKNOWN_REASON
                )
            );
        }

        $this->setCache($configs);

        return $configs;
    }

    /**
     * @param array $registryConfig
     * @param array $pluginConfigsBc
     *
     * @return array
     */
    protected function mergeRegistryConfigBc(
        array $registryConfig,
        array $pluginConfigsBc
    ) {
        foreach ($pluginConfigsBc as $name => $pluginConfigBc) {
            $pluginConfigBc[BlockComponentConfigFields::COMPONENT_CONFIG_READER] = ReadBlockComponentConfigBc::class;
            $pluginConfigsBc[$name] = $pluginConfigBc;
        }

        return array_merge(
            $pluginConfigsBc,
            $registryConfig
        );
    }
}
