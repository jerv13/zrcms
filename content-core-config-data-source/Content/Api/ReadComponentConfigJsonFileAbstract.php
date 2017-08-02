<?php

namespace Zrcms\ContentCoreConfigDataSource\Content\Api;

use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentConfigFields;
use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentRegistryFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ReadComponentConfigJsonFileAbstract implements ReadComponentConfig
{
    /**
     * @var string
     */
    protected $jsonFileName;

    /**
     * @param string $jsonFileName
     */
    public function __construct(
        string $jsonFileName
    ) {
        $this->jsonFileName = $jsonFileName;
    }

    /**
     * @param string $directory
     * @param array  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        string $directory,
        array $options = []
    ): array
    {
        $directory = realpath($directory);
        $configFilePath = realpath($directory . '/' . $this->jsonFileName);

        $configFileContents = file_get_contents($configFilePath);
        /** @var array $config */
        $config = json_decode($configFileContents, true, 512, JSON_BIGINT_AS_STRING);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception(get_class($this) . ' received invalid JSON from: ' . $configFilePath);
        }
        $config[ComponentRegistryFields::CONFIG_LOCATION] = $directory;

        return $config;
    }
}
