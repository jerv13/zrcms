<?php

namespace Zrcms\Core\Block\Api;

use Zrcms\CoreConfigDataSource\Block\Model\BlockConfigFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadBlockConfigJsonFile implements ReadBlockConfig
{
    const JSON_FILE_NAME = 'block.json';

    /**
     * @param string $blockPath
     * @param array  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        string $blockPath,
        array $options = []
    ): array
    {
        $blockPath = realpath($blockPath);
        $configFilePath = realpath($blockPath . '/' . self::JSON_FILE_NAME);

        $configFileContents = file_get_contents($configFilePath);
        $config = json_decode($configFileContents, true, 512, JSON_BIGINT_AS_STRING);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('ReadBlockConfigJsonFile received invalid JSON from: ' . $configFilePath);
        }
        $config[BlockConfigFields::DIRECTORY] = $blockPath;

        return $config;
    }
}
