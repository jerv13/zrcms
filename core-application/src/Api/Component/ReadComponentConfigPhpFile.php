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
    const READER_SCHEME = 'php-file';

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
        AssertValidReaderScheme::invoke(static::READER_SCHEME, $componentConfigUri);

        $componentConfigUriParts = parse_url($componentConfigUri);
        $phpFilePath = $componentConfigUriParts['path'];

        $realConfigFilePath = realpath($phpFilePath);

        if (empty($realConfigFilePath)) {
            throw new \Exception(
                "PHP file path is not valid: ({$phpFilePath})"
            );
        }

        /** @var array $componentConfig */
        $componentConfig = include($realConfigFilePath);

        // if no moduleDirectory is set, we use the config file location
        $moduleDirectoryConfig = Param::getString(
            $componentConfig,
            FieldsComponentConfig::MODULE_DIRECTORY,
            ''
        );

        $moduleDirectoryRoot = pathinfo($realConfigFilePath, PATHINFO_DIRNAME);

        $componentConfig[FieldsComponentConfig::MODULE_DIRECTORY] = $moduleDirectoryRoot . $moduleDirectoryConfig;
        $componentConfig[FieldsComponentConfig::CONFIG_URI] = static::READER_SCHEME . ':' . $realConfigFilePath;

        return $componentConfig;
    }
}
