<?php

namespace Zrcms\User;

use RcmUser\Service\RcmUserService;
use Zrcms\User\Api\GetUserIdByRequest;
use Zrcms\User\Api\GetUserIdByRequestRcmUser;
use Zrcms\User\Api\LogOut;
use Zrcms\User\Api\LogOutRcmUser;

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
                    /**
                     * Api ===========================================
                     */
                    GetUserIdByRequest::class => [
                        'class' => GetUserIdByRequestRcmUser::class,
                        'arguments' => [
                            RcmUserService::class
                        ],
                    ],
                    LogOut::class => [
                        'class' => LogOutRcmUser::class,
                        'arguments' => [
                            RcmUserService::class
                        ],
                    ]
                ],
            ],
        ];
    }
}
