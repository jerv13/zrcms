<?php

namespace Zrcms\Mustache;

use Zrcms\Cache\Service\Cache;
use Zrcms\Mustache\Resolver\FileResolver;

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
                    FileResolver::class => [
                        'arguments' => [
                            Cache::class
                        ]
                    ],
                ],
            ],
        ];
    }
}
