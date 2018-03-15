<?php

namespace Zrcms\HttpApiSite;

use Zrcms\HttpApi\Acl\HttpApiIsAllowedDynamic;
use Zrcms\HttpApi\Dynamic\HttpApiDynamic;
use Zrcms\HttpApiSite\CmsResource\HttpApiFindSiteCmsResourceByHostDynamic;

/**
 * @author James Jervis - https:/github.com/jerv13
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
                'zrcms.api.cms-resources.site.find-by-host.{zrcms-site-host}' => [
                    'name' => 'zrcms.api.cms-resources.site.find-by-host.{zrcms-site-host}',
                    'path' => '/zrcms/api/cms-resources/site/find-by-host/{zrcms-site-host}',
                    'middleware' => [
                        'dynamic' => HttpApiDynamic::class,
                        'acl' => HttpApiIsAllowedDynamic::class,
                        'api' => HttpApiFindSiteCmsResourceByHostDynamic::class,
                    ],
                    'options' => [
                        'zrcms-api' => 'find-site-cms-resource-by-host',
                        'zrcms-implementation' => 'site'
                    ],
                    'allowed_methods' => ['GET']
                ]
            ],
        ];
    }
}
