<?php

namespace Zrcms\Acl;

use RcmUser\Api\Authentication\HasIdentity;
use Zrcms\Acl\Api\IsAllowed;
use Zrcms\Acl\Api\IsAllowedAny;
use Zrcms\Acl\Api\IsAllowedNone;
use Zrcms\Acl\Api\IsAllowedRcmUser;
use Zrcms\Acl\Api\IsAllowedRcmUserLoggedIn;
use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;
use Zrcms\Acl\Api\IsAllowedRelivServerEnvironment;
use Zrcms\Acl\Api\IsAllowedRelivServerEnvironmentNoneProduction;
use Zrcms\Acl\Api\IsAllowedRelivServerEnvironmentProduction;

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
                    IsAllowed::class => [
                        // @todo Default should be secure
                        'class' => IsAllowedAny::class,
                    ],
                    IsAllowedAny::class => [],
                    IsAllowedNone::class => [],
                    IsAllowedRcmUser::class => [
                        'arguments' => [
                            \RcmUser\Api\Acl\IsAllowed::class
                        ],
                    ],
                    IsAllowedRcmUserSitesAdmin::class => [
                        'arguments' => [
                            IsAllowedRcmUser::class
                        ],
                    ],
                    IsAllowedRcmUserLoggedIn::class => [
                        'arguments' => [
                            HasIdentity::class
                        ],
                    ],
                    IsAllowedRelivServerEnvironment::class => [
                        'arguments' => [
                            ['literal' => []]
                        ],
                    ],
                    IsAllowedRelivServerEnvironmentNoneProduction::class => [],
                    IsAllowedRelivServerEnvironmentProduction::class => [],
                ],
            ],
        ];
    }
}
