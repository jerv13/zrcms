<?php

namespace Zrcms\Mustache;

use Zrcms\Cache\Service\CacheArray;
use Zrcms\Mustache\Resolver\FileResolver;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * __invoke
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    FileResolver::class => [
                        'arguments' => [
                            CacheArray::class
                        ]
                    ],
                ],
            ],
        ];
    }
}
