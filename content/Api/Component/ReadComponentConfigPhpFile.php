<?php

namespace Zrcms\Content\Api\Component;

use Zrcms\Content\Fields\FieldsComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigPhpFile implements ReadComponentConfig
{
    const SERVICE_ALIAS = 'php-file';

    /**
     * @param string $phpFilePath
     * @param array  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        string $phpFilePath,
        array $options = []
    ): array {
        $realConfigFilePath = realpath($phpFilePath);

        if (empty($realConfigFilePath)) {
            throw new \Exception(
                "PHP file path is not valid: ({$phpFilePath})"
            );
        }

        /** @var array $config */
        $config = include($realConfigFilePath);

        $config[FieldsComponentConfig::CONFIG_LOCATION] = $realConfigFilePath;

        return $config;
    }
}
