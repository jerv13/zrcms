<?php

namespace Zrcms\ContentCore\Block\Api;

use Zrcms\Content\Model\PropertiesComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadBlockComponentConfigBc implements ReadBlockComponentConfig
{
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
        $config = $this->pluginConfig[$configKey];

        $config[PropertiesComponent::CONFIG_LOCATION] = "BC config:['rcmPlugin'][{$configKey}]";

        return $config;
    }
}
