<?php

namespace Zrcms\Acl;

use RcmUser\Service\RcmUserService;
use Zrcms\Acl\Api\IsAllowed;
use Zrcms\Acl\Api\IsAllowedAny;
use Zrcms\Acl\Api\IsAllowedRcmUser;

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
                    IsAllowed::class => [
                        'class' => IsAllowedAny::class,
                    ],
                    IsAllowedAny::class => [
                        'class' => IsAllowedAny::class,
                        'arguments' => [],
                    ],
                    IsAllowedRcmUser::class => [
                        'arguments' => [
                            RcmUserService::class
                        ],
                    ],
                ],
            ],
        ];
    }
}
