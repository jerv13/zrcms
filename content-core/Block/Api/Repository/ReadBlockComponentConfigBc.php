<?php

namespace Zrcms\ContentCore\Block\Api\Repository;

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

        return $config;
    }
}
