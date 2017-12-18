<?php

namespace Zrcms\ViewAssets\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetCacheBreakerPhpFile implements GetCacheBreaker
{
    protected $filePath;

    /**
     * @param string $filePath
     *
     * @throws \Exception
     */
    public function __construct(
        string $filePath
    ) {
        if (!file_exists($filePath)) {
            throw new \Exception(
                'Cache breaker file does not exist: ' . $filePath
            );
        }
        $this->filePath = $filePath;
    }

    /**
     * @param array $options
     *
     * @return string
     * @throws \Exception
     */
    public function __invoke(
        array $options = []
    ): string {
        $cacheData = include($this->filePath);

        if (!is_array($cacheData)) {
            throw new \Exception(
                'Cache breaker file must return array: ' . $this->filePath
            );
        }

        if (!array_key_exists(static::KEY_VERSION, $cacheData)) {
            throw new \Exception(
                'Cache breaker file must return array: ' . $this->filePath
                . ' with key: ' . static::KEY_VERSION
            );
        }

        return $cacheData[static::KEY_VERSION];
    }
}
