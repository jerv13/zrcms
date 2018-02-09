<?php

namespace Zrcms\CoreApplication\Api\Component;

use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\Core\Exception\CanNotReadComponentConfig;
use Zrcms\Core\Fields\FieldsComponentConfig;
use Reliv\Json\Json;
use Reliv\ArrayProperties\Property;

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

        $jsonFilePath = parse_url($componentConfigUri, PHP_URL_PATH);

        $realConfigFilePath = realpath($jsonFilePath);

        if (empty($realConfigFilePath)) {
            throw new \Exception(
                "JSON file path is not valid: ({$jsonFilePath})"
            );
        }

        $configFileContents = file_get_contents($realConfigFilePath);

        /** @var array $componentConfig */
        $componentConfig = Json::decode(
            $configFileContents,
            true,
            512,
            JSON_BIGINT_AS_STRING,
            get_class($this) . ' received invalid JSON from: ' . $realConfigFilePath
        );

        // if no moduleDirectory is set, we use the config file location
        $moduleDirectoryConfig = $componentConfig[FieldsComponentConfig::MODULE_DIRECTORY] = Property::getString(
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
     * @param $componentConfigUri
     *
     * @return void
     * @throws CanNotReadComponentConfig
     */
    protected function assertCanRead($componentConfigUri)
    {
        $scheme = parse_url($componentConfigUri, PHP_URL_SCHEME);
        if ($scheme !== static::READER_SCHEME && !empty($scheme)) {
            throw new CanNotReadComponentConfig(
                'Component Config Uri not valid: ' . $componentConfigUri
                . ' for ' . get_class($this)
            );
        }

        AssertValidReaderScheme::invoke(static::READER_SCHEME, $componentConfigUri);
    }
}
