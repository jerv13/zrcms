<?php

namespace Zrcms\HttpAssetsAdminTools;

use Zrcms\HttpAssetsAdminTools\Middleware\HttpAdminToolsComponentCss;
use Zrcms\HttpAssetsAdminTools\Middleware\HttpAdminToolsComponentJs;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigRoutes
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'routes' => [
                'zrcms.admin-tools.{zrcms-component-type}.css' => [
                    'name' => 'zrcms.admin-tools.{zrcms-component-type}.css',
                    'path' => '/zrcms/admin-tools/{zrcms-component-type}.css',
                    'middleware' => [
                        'middleware' => HttpAdminToolsComponentCss::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
                'zrcms.admin-tools.{zrcms-component-type}.js' => [
                    'name' => 'zrcms.admin-tools.{zrcms-component-type}.js',
                    'path' => '/zrcms/admin-tools/{zrcms-component-type}.js',
                    'middleware' => [
                        'middleware' => HttpAdminToolsComponentJs::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],
        ];
    }
}
