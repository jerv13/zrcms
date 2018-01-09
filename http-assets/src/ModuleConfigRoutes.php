<?php

namespace Zrcms\HttpAssets;

use Zrcms\HttpAssets\Middleware\HttpComponentCss;
use Zrcms\HttpAssets\Middleware\HttpComponentJs;

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
                'zrcms.component.{zrcms-component-type}.css' => [
                    'name' => 'zrcms.component.{zrcms-component-type}.css',
                    'path' => '/zrcms/component/{zrcms-component-type}.css',
                    'middleware' => [
                        'middleware' => HttpComponentCss::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
                'zrcms.component.{zrcms-component-type}.js' => [
                    'name' => 'zrcms.component.{zrcms-component-type}.js',
                    'path' => '/zrcms/component/{zrcms-component-type}.js',
                    'middleware' => [
                        'middleware' => HttpComponentJs::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],
        ];
    }
}
