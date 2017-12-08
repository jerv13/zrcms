<?php

namespace Zrcms\CoreBlock\Api\Component;

use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\CoreBlock\Api\Render\RenderBlockBc;
use Zrcms\CoreBlock\Fields\FieldsBlockComponentConfig;
use ZrcmsRcmCompatibility\RcmAdapter\ComponentBlockConfigBC;

/**
 * @deprecated BC only
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigBlockBc implements ReadComponentConfig
{
    const SERVICE_ALIAS = 'bc-block';
    const READER_PROTOCOL = 'bc-block://';

    /**
     * @param string $rcmPluginName
     * @param array  $rcmPluginConfig
     * @param array  $componentConfig
     * @param string $moduleDirectory
     *
     * @return array
     */
    public static function buildBcPluginConfig(
        string $rcmPluginName,
        array $rcmPluginConfig,
        array $componentConfig = [],
        $moduleDirectory = __DIR__ . '/../../..'
    ): array {
        $componentConfig = FixBlockConfigTypeCategoryCollisionBc::invoke(
            $rcmPluginConfig,
            $componentConfig
        );

        $componentConfig[FieldsBlockComponentConfig::COMPONENT_CONFIG_READER]
            = ReadComponentConfigBlockBc::SERVICE_ALIAS;
        $componentConfig[FieldsBlockComponentConfig::CONFIG_LOCATION]
            = $rcmPluginName;
        $componentConfig[FieldsBlockComponentConfig::MODULE_DIRECTORY]
            = $moduleDirectory;
        $componentConfig[FieldsBlockComponentConfig::NAME]
            = $rcmPluginName;
        $componentConfig[FieldsBlockComponentConfig::RENDERER]
            = RenderBlockBc::SERVICE_ALIAS;

        return $componentConfig;
    }

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

        $config = self::buildBcPluginConfig(
            $configKey,
            $this->pluginConfig[$configKey],
            $this->pluginConfig[$configKey]
        );

        return $config;
    }
}
