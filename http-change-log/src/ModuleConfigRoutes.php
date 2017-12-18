<?php

namespace Zrcms\HttpChangeLog;

use Zrcms\HttpChangeLog\Middleware\ChangeLogList;
use Zrcms\HttpChangeLog\Middleware\IsAllowedReadChangeLog;

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
