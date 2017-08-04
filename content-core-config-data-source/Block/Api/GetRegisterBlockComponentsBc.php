<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Model\ComponentConfigFields;
use Zrcms\Content\Model\Trackable;
use Zrcms\ContentCore\Block\Api\PrepareBlockConfigBc;
use Zrcms\ContentCore\Block\Api\ReadBlockComponentConfigBc;
use Zrcms\ContentCore\Block\Model\BlockComponentBasic;
use Zrcms\ContentCoreConfigDataSource\Block\Model\BlockComponentRegistryFields;
use Zrcms\ContentCoreConfigDataSource\Content\Api\GetRegisterComponentsAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetRegisterBlockComponentsBc extends GetRegisterComponentsAbstract implements GetRegisterBlockComponents
{
    const CACHE_KEY = 'ZrcmsBlockComponentConfigBc';
    /**
     * @var array
     */
    protected $registryConfig;

    /**
     * @var PrepareBlockConfigBc
     */
    protected $prepareBlockConfig;

    /**
     * @param array                      $registryConfig
     * @param array                      $pluginConfigsBc
     * @param ReadBlockComponentConfigBc $readBlockComponentConfig
     * @param Cache                      $cache
     * @param PrepareBlockConfigBc       $prepareBlockConfig
     * @param string                     $componentClass
     * @param string                     $cacheKey \
     */
    public function __construct(
        array $registryConfig,
        array $pluginConfigsBc,
        ReadBlockComponentConfigBc $readBlockComponentConfig,
        Cache $cache,
        PrepareBlockConfigBc $prepareBlockConfig,
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
            $pluginConfigBc[BlockComponentRegistryFields::COMPONENT_CONFIG_READER] = ReadBlockComponentConfigBc::class;
            $pluginConfigsBc[$name] = $pluginConfigBc;
        }

        return array_merge(
            $pluginConfigsBc,
            $registryConfig
        );
    }
}
