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
    const READER_PROTOCOL = 'json://';

    /**
     * @param string $jsonFilePath
     * @param array  $options
     *
     * @return array
     * @throws \Exception|CanNotReadComponentConfig
     */
    public function __invoke(
        string $jsonFilePath,
        array $options = []
    ): array {
        $this->assertCanRead($jsonFilePath);

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
        $componentConfig[FieldsComponentConfig::MODULE_DIRECTORY] = Param::get(
            $componentConfig,
            FieldsComponentConfig::MODULE_DIRECTORY,
            pathinfo($realConfigFilePath)[PATHINFO_DIRNAME]
        );

        $componentConfig[FieldsComponentConfig::CONFIG_LOCATION] = self::READER_PROTOCOL . $realConfigFilePath;

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
        // NOTE: this allows no protocol on json files, is a bit risky
        if (substr($jsonFilePath, -5) === '.json') {
            return;
        }
        AssertValidReaderProtocol::invoke(self::READER_PROTOCOL, $jsonFilePath);
    }
}
