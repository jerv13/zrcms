<?php

namespace Zrcms\CoreApplication\Api\Component;

use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\Core\Exception\CanNotReadComponentConfig;
use Zrcms\Core\Fields\FieldsComponentConfig;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigJsonFile implements ReadComponentConfig
{
    const SERVICE_ALIAS = 'json';
    const READER_SCHEME = 'json';

    /**
     * @param string $componentConfigUri
     * @param array  $options
     *
     * @return array
     * @throws \Exception|CanNotReadComponentConfig
     */
    public function __invoke(
        string $componentConfigUri,
        array $options = []
    ): array {
        $this->assertCanRead($componentConfigUri);

        $componentConfigUriParts = parse_url($componentConfigUri);
        $jsonFilePath = $componentConfigUriParts['path'];

        $realConfigFilePath = realpath($jsonFilePath);

        if (empty($realConfigFilePath)) {
            throw new \Exception(
                "JSON file path is not valid: ({$jsonFilePath})"
            );
        }

        $configFileContents = file_get_contents($realConfigFilePath);

        /** @var array $componentConfig */
        $componentConfig = json_decode($configFileContents, true, 512, JSON_BIGINT_AS_STRING);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception(get_class($this) . ' received invalid JSON from: ' . $realConfigFilePath);
        }

        // if no moduleDirectory is set, we use the config file location
        $moduleDirectoryConfig = $componentConfig[FieldsComponentConfig::MODULE_DIRECTORY] = Param::getString(
            $componentConfig,
            FieldsComponentConfig::MODULE_DIRECTORY,
            ''
        );

        $moduleDirectoryRoot = pathinfo($realConfigFilePath, PATHINFO_DIRNAME);

        $moduleDirectory = $moduleDirectoryRoot . $moduleDirectoryConfig;

        $componentConfig[FieldsComponentConfig::MODULE_DIRECTORY] = $moduleDirectory;
        $componentConfig[FieldsComponentConfig::CONFIG_URI] = static::READER_SCHEME . ':' . $realConfigFilePath;

        return $componentConfig;
    }

    /**
     * @param $jsonFilePath
     *
     * @return void
     * @throws CanNotReadComponentConfig
     */
    protected function assertCanRead($jsonFilePath)
    {
        AssertValidReaderScheme::invoke(static::READER_SCHEME, $jsonFilePath);
    }
}
