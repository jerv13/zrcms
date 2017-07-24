<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api;

use Zrcms\ContentCoreConfigDataSource\Block\Model\BlockConfigFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadBlockConfigJsonFile implements ReadBlockConfig
{
    const JSON_FILE_NAME = 'block.json';

    /**
     * @param string $blockDirectory
     * @param array  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        string $blockDirectory,
        array $options = []
    ): array
    {
        $blockDirectory = realpath($blockDirectory);
        $configFilePath = realpath($blockDirectory . '/' . self::JSON_FILE_NAME);

        $configFileContents = file_get_contents($configFilePath);
        $config = json_decode($configFileContents, true, 512, JSON_BIGINT_AS_STRING);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('ReadBlockConfigJsonFile received invalid JSON from: ' . $configFilePath);
        }
        $config[BlockConfigFields::DIRECTORY] = $blockDirectory;

        return $config;
    }
}
