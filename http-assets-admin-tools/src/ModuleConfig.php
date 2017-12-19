<?php

namespace Zrcms\HttpAssetsAdminTools;

use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\Core\Api\GetComponentJs;
use Zrcms\HttpAssetsAdminTools\Middleware\AdminToolsBlockJs;

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
                    AdminToolsBlockJs::class => [
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
