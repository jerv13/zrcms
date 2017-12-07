<?php

namespace Zrcms\CoreBlock\Api\Component;

use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\CoreBlock\Api\Render\RenderBlockBc;
use Zrcms\CoreBlock\Fields\FieldsBlockComponentConfig;
use ZrcmsRcmCompatibility\RcmAdapter\ComponentBlockRegistryBC;

/**
 * @deprecated BC only
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigBlockBc implements ReadComponentConfig
{
    const SERVICE_ALIAS = 'bc-block';

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
    ): array {
        if (!array_key_exists($configKey, $this->pluginConfig)) {
            throw new \Exception(
                "Config key not found: ({$configKey})"
            );
        }

        $config = ComponentBlockRegistryBC::getBcPluginConfig(
            $configKey,
            $this->pluginConfig[$configKey],
            $this->pluginConfig[$configKey]
        );

        return $config;
    }
}
