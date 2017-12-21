<?php

namespace Zrcms\PageAccess;

use Zrcms\PageAccess\Api\Acl\IsAllowedPageAccess;
use Zrcms\PageAccess\Api\Acl\IsAllowedPageAccessRcmUserRoleFactory;
use Zrcms\PageAccess\Middleware\PageAccessByView;
use Zrcms\PageAccess\Middleware\PageAccessByViewFactory;

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

                    PageAccessByView::class => [
                        'factory' => PageAccessByViewFactory::class
                    ],
                ],
            ],
        ];
    }
}
