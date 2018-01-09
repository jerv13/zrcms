<?php

namespace Zrcms\HttpUser;

use Zrcms\HttpUser\Middleware\HttpParamLogOut;
use Zrcms\User\Api\LogOut;

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
                    HttpParamLogOut::class => [
                        'arguments' => [
                            LogOut::class,
                        ],
                    ],
                ],
            ],
        ];
    }
}
