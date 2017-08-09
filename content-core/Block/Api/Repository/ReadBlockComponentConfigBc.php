<?php

namespace Zrcms\ContentCore\Block\Api\Repository;

use Zrcms\ContentCore\Block\Api\Render\RenderBlockBc;
use Zrcms\ContentCore\Block\Model\BlockComponentConfigFields;

/**
 * @deprecated BC only
 * @author James Jervis - https://github.com/jerv13
 */
class ReadBlockComponentConfigBc implements ReadBlockComponentConfig
{
    const SERVICE_ALIAS = 'bc';

    /**
     * @var array
     */
    protected $pluginConfig;

    /**
     * @param array $pluginConfig
     */
    public function __construct(
        array $pluginConfig
    ) {
        $this->pluginConfig = $pluginConfig;
    }

    /**
     * @param string $configKey
     * @param array  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        string $configKey,
        array $options = []
    ): array
    {
        if (!array_key_exists($configKey, $this->pluginConfig)) {
            throw new \Exception(
                "Config key not found: ({$configKey})"
            );
        }
        $config = $this->pluginConfig[$configKey];

        $config[BlockComponentConfigFields::COMPONENT_CONFIG_READER] = ReadBlockComponentConfigBc::SERVICE_ALIAS;
        $config[BlockComponentConfigFields::CONFIG_LOCATION] = $configKey;
        $config[BlockComponentConfigFields::NAME] = $configKey;
        $config[BlockComponentConfigFields::RENDERER] = RenderBlockBc::SERVICE_ALIAS;

        return $config;
    }
}