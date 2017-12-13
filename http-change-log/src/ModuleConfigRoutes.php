<?php

namespace Zrcms\HttpChangeLog;

use Zrcms\Acl\Api\IsAllowedRcmUser;
use Zrcms\Core\Api\ChangeLog\GetChangeLogByDateRange;
use Zrcms\CoreApplication\Api\ChangeLog\ChangeLogEventToString;
use Zrcms\CoreApplication\Api\ChangeLog\GetContentChangeLogComposite;
use Zrcms\CoreApplication\Api\ChangeLog\GetHumanReadableChangeLogByDateRange;
use Zrcms\CoreContainer\Api\ChangeLog\GetChangeLogByDateRange as ContainerGetChangeLogByDateRange;
use Zrcms\CorePage\Api\ChangeLog\GetChangeLogByDateRange as PageGetChangeLogByDateRange;
use Zrcms\CoreRedirect\Api\ChangeLog\GetChangeLogByDateRange as RedirectGetChangeLogByDateRange;
use Zrcms\CoreSite\Api\ChangeLog\GetChangeLogByDateRange as SiteGetChangeLogByDateRange;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResource;
use Zrcms\CoreTheme\Api\ChangeLog\GetChangeLogByDateRange as ThemeGetChangeLogByDateRange;
use Zrcms\HttpChangeLog\Middleware\ChangeLogList;
use Zrcms\HttpChangeLog\Middleware\IsAllowedReadChangeLog;

class ModuleConfigRoutes
{
    /**
     * __invoke
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'routes' => [
                /*
                 * Usage Note: For a friendly HTML UI, try adding ?days=30&content-type=text%2Fhtml
                 */
                '/zrcms/change-log' => [
                    'name' => '/zrcms/change-log',
                    'path' => '/zrcms/change-log',
                    'middleware' => [
                        'acl' => IsAllowedReadChangeLog::class, // over-ride me
                        'controller' => ChangeLogList::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],
        ];
    }
}
