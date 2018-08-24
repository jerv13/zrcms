<?php

namespace Zrcms\PageAccess;

use Zrcms\PageAccess\Api\Acl\IsAllowedPageAccess;
use Zrcms\PageAccess\Api\Acl\IsAllowedPageAccessRcmUserRoleFactory;
use Zrcms\PageAccess\Api\GetApplicationStatePageAccess;
use Zrcms\PageAccess\Api\GetApplicationStatePageAccessFactory;
use Zrcms\PageAccess\Middleware\HttpPageAccessByView;
use Zrcms\PageAccess\Middleware\HttpPageAccessByViewFactory;

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
                    IsAllowedPageAccess::class => [
                        'factory' => IsAllowedPageAccessRcmUserRoleFactory::class
                    ],

                    HttpPageAccessByView::class => [
                        'factory' => HttpPageAccessByViewFactory::class
                    ],

                    GetApplicationStatePageAccess::class => [
                        'factory' => GetApplicationStatePageAccessFactory::class
                    ],
                ],
            ],
        ];
    }
}
