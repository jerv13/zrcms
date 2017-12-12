<?php

namespace Zrcms\CoreBlock\Api\Component;

use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\CoreApplication\Api\Component\AssertValidReaderScheme;
use Zrcms\CoreBlock\Api\Render\RenderBlockBc;
use Zrcms\CoreBlock\Fields\FieldsBlockComponentConfig;

/**
 * @deprecated BC only
 * @author     James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigBlockBc implements ReadComponentConfig
{
    const SERVICE_ALIAS = 'block-bc';
    const READER_SCHEME = 'block-bc';

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
        $componentConfig[FieldsBlockComponentConfig::CONFIG_URI]
            = $rcmPluginName;
        $componentConfig[FieldsBlockComponentConfig::MODULE_DIRECTORY]
            = $moduleDirectory;
        $componentConfig[FieldsBlockComponentConfig::NAME]
            = $rcmPluginName;
        $componentConfig[FieldsBlockComponentConfig::RENDERER]
            = RenderBlockBc::SERVICE_ALIAS;
        $componentConfig[FieldsBlockComponentConfig::TYPE] = 'block';

        return $componentConfig;
    }

    protected $pluginConfig;
    protected $prepareComponentConfig;

    /**
     * @param array                       $pluginConfig
     * @param PrepareComponentConfigBlock $prepareComponentConfig
     */
    public function __construct(
        array $pluginConfig,
        PrepareComponentConfigBlock $prepareComponentConfig
    ) {
        $this->pluginConfig = $pluginConfig;
        $this->prepareComponentConfig = $prepareComponentConfig;
    }

    /**
     * @param string $componentConfigUri
     * @param array  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        string $componentConfigUri,
        array $options = []
    ): array {
        AssertValidReaderScheme::invoke(self::READER_SCHEME, $componentConfigUri);

        $componentConfigUriParts = parse_url($componentConfigUri);
        $configKey = $componentConfigUriParts['path'];

        if (!array_key_exists($configKey, $this->pluginConfig)) {
            throw new \Exception(
                "Config key not found: ({$configKey})"
            );
        }

        $componentConfig = self::buildBcPluginConfig(
            $configKey,
            $this->pluginConfig[$configKey],
            $this->pluginConfig[$configKey]
        );

        return $this->prepareComponentConfig->__invoke(
            $componentConfig
        );
    }
}
