<?php

namespace Zrcms\Content\Api\Component;

use Zrcms\Content\Fields\FieldsComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ReadComponentConfigJsonFileAbstract
{
    /**
     * @param string $jsonFilePath
     * @param array  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        string $jsonFilePath,
        array $options = []
    ): array {
        $realConfigFilePath = realpath($jsonFilePath);

        if (empty($realConfigFilePath)) {
            throw new \Exception(
                "JSON file path is not valid: ({$jsonFilePath})"
            );
        }

        $configFileContents = file_get_contents($realConfigFilePath);

        /** @var array $config */
        $config = json_decode($configFileContents, true, 512, JSON_BIGINT_AS_STRING);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception(get_class($this) . ' received invalid JSON from: ' . $realConfigFilePath);
        }
        $config[FieldsComponentConfig::CONFIG_LOCATION] = $realConfigFilePath;

        return $config;
    }
}
