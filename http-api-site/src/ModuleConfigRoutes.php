<?php

namespace Zrcms\HttpApiSite;

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
//                'zrcms.site.cms-resource' => [
//                    'name' => 'zrcms.site.cms-resource',
//                    'path' => '/zrcms/site/cms-resource',
//                    'middleware' => [
//                        'parser' => BodyParamsMiddleware::class,
//                        'acl' => HttpApiIsAllowedSitePublishIsAllowed::class,
//                        'validator-data' => HttpApiUpsertSiteCmsResourceZfInputFilterServiceHttpApi::class,
//                        'api' => UpsertSiteCmsResource::class,
//                    ],
//                    'options' => [],
//                    'allowed_methods' => ['PUT'],
//                ],
            ],
        ];
    }
}
