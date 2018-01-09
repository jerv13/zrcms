<?php

namespace Zrcms\HttpAssetsChangeLog;

use Zrcms\HttpAssetsChangeLog\Middleware\HttpChangeLogList;
use Zrcms\HttpAssetsChangeLog\Middleware\HttpIsAllowedReadChangeLogIsAllowed;

class ModuleConfigRoutes
{
    /**
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
                        'acl' => HttpIsAllowedReadChangeLogIsAllowed::class, // over-ride me
                        'controller' => HttpChangeLogList::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],
        ];
    }
}
