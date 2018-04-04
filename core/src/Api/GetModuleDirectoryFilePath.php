<?php

namespace Zrcms\Core\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetModuleDirectoryFilePath
{
    /**
     * @param string $moduleDirectory
     * @param string $filePathUri
     * @param string $context
     *
     * @return string
     * @throws \Exception
     */
    public function __invoke(
        string $moduleDirectory,
        string $filePathUri,
        string $context = 'unknown'
    ): string;
}
