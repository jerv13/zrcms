<?php

namespace Zrcms\ContentCoreConfigDataSource\Content\Api;

use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentConfigFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ReadComponentConfigPhpFileAbstract implements ReadComponentConfig
{
    /**
     * @var string
     */
    protected $phpFileName;

    /**
     * @param string $phpFileName
     */
    public function __construct(
        string $phpFileName
    ) {
        $this->phpFileName = $phpFileName;
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
        $configFilePath = realpath($directory . '/' . $this->phpFileName);

        /** @var array $config */
        $config = include($configFilePath);

        $config[ComponentConfigFields::LOCATION] = $directory;

        return $config;
    }
}
