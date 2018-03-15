<?php

namespace Zrcms\HttpSiteMap;

use Zrcms\HttpSiteMap\Middleware\SiteMap;

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
                'zrcms-sitemap.xml' => [
                    'name' => 'zrcms-sitemap.xml',
                    'path' => '/sitemap.xml',
                    'middleware' => [
                        'controller' => SiteMap::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],
        ];
    }
}
