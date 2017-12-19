<?php

namespace Zrcms\HttpAssets\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetCacheBreaker
{
    const CACHE_BREAKER_PARAM = 'cacheBreaker';
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
