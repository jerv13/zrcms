<?php

namespace Zrcms\CoreBlock\Api\Component;

use Zrcms\Core\Api\Component\ReadComponentRegistry;
use Zrcms\Core\Fields\FieldsComponentConfig;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigJsonFile;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentRegistryRcmPluginBc implements ReadComponentRegistry
{
    /**
     * @param       $appConfig
     * @param array $componentRegistry
     *
     * @return array
     * @throws \Exception
     */
    public static function invoke($appConfig, $componentRegistry = []): array
    {
        foreach ($appConfig['rcmPlugin'] as $rcmPluginName => $rcmPluginConfig) {
            $componentRegistry['block.' . $rcmPluginName]
                = ReadComponentConfigBlockBc::READER_SCHEME . ':' . $rcmPluginName;
        }

        foreach ($appConfig['Rcm']['blocks'] as $rcmPluginBlockConfigDir) {

            $rcmPluginBlockConfigDir = realpath($rcmPluginBlockConfigDir);
            $rcmPluginConfigJson = file_get_contents(
                realpath($rcmPluginBlockConfigDir . '/block.json')
            );

            $rcmPluginConfig = json_decode($rcmPluginConfigJson, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Received invalid JSON from file: ' . $rcmPluginConfigJson);
            }

            $rcmPluginName = Param::getRequired(
                $rcmPluginConfig,
                FieldsComponentConfig::NAME
            );

            $componentRegistry['block.' . $rcmPluginName]
                = ReadComponentConfigJsonFile::READER_SCHEME . ':' . $rcmPluginBlockConfigDir . '/block.json';
        }

        return $componentRegistry;
    }

    /**
     * @var array
     */
    protected $appConfig;

    /**
     * @param array $appConfig
     */
    public function __construct(
        array $appConfig
    ) {
        $this->appConfig = $appConfig;
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function __invoke(
        array $options = []
    ): array {
        return self::invoke($this->appConfig);
    }
}
