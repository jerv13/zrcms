<?php

namespace Zrcms\Content\Api\Component;

use Zrcms\Content\Fields\FieldsComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ReadComponentConfigPhpFileAbstract
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
     * @param string $phpFilePath
     * @param array  $options
     *
     * @return array
     */
    public function __invoke(
        string $phpFilePath,
        array $options = []
    ): array {
        $realConfigFilePath = realpath($phpFilePath);

        if (empty($realConfigFilePath)) {
            throw new \Exception(
                "JSON file path is not valid: ({$phpFilePath})"
            );
        }

        /** @var array $config */
        $config = include($realConfigFilePath);

        $config[FieldsComponentConfig::CONFIG_LOCATION] = $realConfigFilePath;

        return $config;
    }
}
