<?php

namespace Zrcms\CoreAdminTools;

use Zrcms\Acl\Api\IsAllowedRcmUser;
use Zrcms\Cache\Service\Cache;
use Zrcms\CoreAdminTools\Api\Acl\IsAllowedAdminToolsRcmUserSitesAdmin;
use Zrcms\CoreAdminTools\Api\GetComponentCssAdminTools;
use Zrcms\CoreAdminTools\Api\GetComponentJsAdminTools;

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
                    IsAllowedAdminToolsRcmUserSitesAdmin::class => [
                        'arguments' => [
                            IsAllowedRcmUser::class
                        ],
                    ],
                    GetComponentCssAdminTools::class => [
                        'arguments' => [
                            IsAllowedAdminToolsRcmUserSitesAdmin::class,
                            ['literal' => []],
                            Cache::class,
                            ['literal' => GetComponentCssAdminTools::DEFAULT_CACHE_KEY]
                        ],
                    ],
                    GetComponentJsAdminTools::class => [
                        'arguments' => [
                            IsAllowedAdminToolsRcmUserSitesAdmin::class,
                            ['literal' => []],
                            Cache::class,
                            ['literal' => GetComponentJsAdminTools::DEFAULT_CACHE_KEY]
                        ],
                    ],
                ],
            ],
        ];
    }
}
