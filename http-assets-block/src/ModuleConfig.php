<?php

namespace Zrcms\HttpAssetsBlock;

use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\Core\Api\GetComponentCss;
use Zrcms\Core\Api\GetComponentJs;
use Zrcms\HttpAssetsBlock\Middleware\BlockCss;
use Zrcms\HttpAssetsBlock\Middleware\BlockJs;

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
                    BlockCss::class => [
                        'arguments' => [
                            FindComponentsBy::class,
                            GetComponentCss::class,
                        ],
                    ],
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
