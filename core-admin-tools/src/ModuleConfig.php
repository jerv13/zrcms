<?php

namespace Zrcms\CoreAdminTools;

use Zrcms\CoreAdminTools\Api\Acl\IsAllowedAdminTools;
use Zrcms\CoreAdminTools\Api\Acl\IsAllowedAdminToolsRcmUserSitesAdmin;
use Zrcms\CoreAdminTools\Api\Acl\IsAllowedAdminToolsRcmUserSitesAdminFactory;
use Zrcms\CoreAdminTools\Api\GetApplicationStateAdminTools;
use Zrcms\CoreAdminTools\Api\GetApplicationStateAdminToolsFactory;
use Zrcms\CoreAdminTools\Api\GetComponentCssAdminTools;
use Zrcms\CoreAdminTools\Api\GetComponentCssAdminToolsFactory;
use Zrcms\CoreAdminTools\Api\GetComponentJsAdminTools;
use Zrcms\CoreAdminTools\Api\GetComponentJsAdminToolsFactory;

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
                        'factory' => GetComponentCssAdminToolsFactory::class,
                    ],
                    GetComponentJsAdminTools::class => [
                        'factory' => GetComponentJsAdminToolsFactory::class,
                    ],
                ],
            ],
        ];
    }
}
