<?php

namespace Zrcms\CoreAdminTools;

use Zrcms\Cache\Service\Cache;
use Zrcms\CoreAdminTools\Api\Acl\IsAllowedAdminTools;
use Zrcms\CoreAdminTools\Api\Acl\IsAllowedAdminToolsRcmUserSitesAdmin;
use Zrcms\CoreAdminTools\Api\Acl\IsAllowedAdminToolsRcmUserSitesAdminFactory;
use Zrcms\CoreAdminTools\Api\GetApplicationStateAdminTools;
use Zrcms\CoreAdminTools\Api\GetApplicationStateAdminToolsFactory;
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
                    IsAllowedAdminTools::class => [
                        'factory' => IsAllowedAdminToolsRcmUserSitesAdminFactory::class,
                    ],
                    IsAllowedAdminToolsRcmUserSitesAdmin::class => [
                        'factory' => IsAllowedAdminToolsRcmUserSitesAdminFactory::class,
                    ],
                    GetApplicationStateAdminTools::class => [
                        'factory' => GetApplicationStateAdminToolsFactory::class,
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
