<?php

namespace Zrcms\ViewAssets\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetCacheBreaker
{
    const KEY_VERSION = 'version';
    const KEY_TIMESTAMP = 'timestamp';

    /**
     * @param array $options
     *
     * @return string
     */
    public function __invoke(
        array $options = []
    ): string;
}
