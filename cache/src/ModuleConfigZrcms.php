<?php

namespace Zrcms\Cache;

use Zrcms\Cache\Service\Cache;
use Zrcms\Cache\Service\CacheArray;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigZrcms
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            /** Register caches so global clears can be applied */
            'zrcms-caches' => [
                Cache::class,
                CacheArray::class,
            ],
        ];
    }
}
