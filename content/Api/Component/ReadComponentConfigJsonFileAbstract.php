<?php

namespace Zrcms\Content\Api\Component;

use Zrcms\Content\Model\PropertiesComponent;

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
        $realDirectory = realpath($directory);

        if (empty($realDirectory)) {
            throw new \Exception("Directory is not valid: ({$directory})");
        }

        $configFilePath = $directory . '/' . $this->jsonFileName;
        $realConfigFilePath = realpath($configFilePath);

        if (empty($realConfigFilePath)) {
            throw new \Exception("File is not valid: ({$directory})");
        }

        $configFileContents = file_get_contents($realConfigFilePath);
        /** @var array $config */
        $config = json_decode($configFileContents, true, 512, JSON_BIGINT_AS_STRING);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception(get_class($this) . ' received invalid JSON from: ' . $realConfigFilePath);
        }
        $config[PropertiesComponent::CONFIG_LOCATION] = $realDirectory;

        return $config;
    }
}
