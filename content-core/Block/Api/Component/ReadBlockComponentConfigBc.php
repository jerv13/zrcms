<?php

namespace Zrcms\ContentCore\Block\Api\Component;

use Zrcms\ContentCore\Block\Api\Render\RenderBlockBc;
use Zrcms\ContentCore\Block\Fields\FieldsBlockComponentConfig;

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

        $config[FieldsBlockComponentConfig::COMPONENT_CONFIG_READER] = ReadBlockComponentConfigBc::SERVICE_ALIAS;
        $config[FieldsBlockComponentConfig::CONFIG_LOCATION] = $configKey;
        $config[FieldsBlockComponentConfig::NAME] = $configKey;
        $config[FieldsBlockComponentConfig::RENDERER] = RenderBlockBc::SERVICE_ALIAS;

        return $config;
    }
}
