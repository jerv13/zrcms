<?php

namespace Zrcms\HttpCoreBlock;

use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\Core\Api\GetComponentJs;
use Zrcms\HttpCoreBlock\Middleware\BlockJs;

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
                    BlockJs::class => [
                        'arguments' => [
                            FindComponentsBy::class,
                            GetComponentJs::class,
                        ],
                    ],
                ],
            ],
        ];
    }
}
