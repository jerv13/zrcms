<?php

namespace Zrcms\CoreApplication\Api\Component;

use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\Core\Fields\FieldsComponentConfig;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigPhpFile implements ReadComponentConfig
{
    const SERVICE_ALIAS = 'php-file';
    const READER_PROTOCOL = 'php-file://';

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
        AssertValidReaderProtocol::invoke(self::READER_PROTOCOL, $phpFilePath);
        $realConfigFilePath = realpath($phpFilePath);

        if (empty($realConfigFilePath)) {
            throw new \Exception(
                "PHP file path is not valid: ({$phpFilePath})"
            );
        }

        /** @var array $componentConfig */
        $componentConfig = include($realConfigFilePath);

        // if no moduleDirectory is set, we use the config file location
        $componentConfig[FieldsComponentConfig::MODULE_DIRECTORY] = Param::get(
            $componentConfig,
            FieldsComponentConfig::MODULE_DIRECTORY,
            pathinfo($realConfigFilePath)[PATHINFO_DIRNAME]
        );

        $componentConfig[FieldsComponentConfig::CONFIG_LOCATION] = self::READER_PROTOCOL . $realConfigFilePath;

        return $componentConfig;
    }
}
