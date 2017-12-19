<?php

namespace Zrcms\HttpAssets;

use Zrcms\HttpAssets\Api\GetCacheBreaker;
use Zrcms\HttpAssets\Api\GetCacheBreakerPhpFile;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    GetCacheBreaker::class => [
                        'class' => GetCacheBreakerPhpFile::class,
                        'arguments' => [
                            ['literal' => __DIR__ . '/../../../../../releaseInfo.php']
                        ],
                    ],
                ],
            ],
        ];
    }
}
