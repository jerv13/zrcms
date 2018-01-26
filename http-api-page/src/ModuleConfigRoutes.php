<?php

namespace Zrcms\HttpApiPage;

use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;
use Zrcms\HttpApiPage\Middleware\SiteMap;

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
                /*
                // Upsert CmsResource
                'zrcms.page.cms-resource' => [
                    'name' => 'zrcms.page.cms-resource',
                    'path' => '/zrcms/page/cms-resource',
                    'middleware' => [
                        'parser' => BodyParamsMiddleware::class,
                        'acl' => IsAllowedPagePublish::class,
                        'validator-data' => UpsertPageCmsResourceZfInputFilterService::class,
                        'api' => UpsertPageCmsResource::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['PUT'],
                ],

                // Find CmsResource
                'zrcms.page.find-cms-resource.id' => [
                    'name' => 'zrcms.page.find-cms-resource.id',
                    'path' => '/zrcms/page/find-cms-resource/{id}',
                    'middleware' => [
                        'acl' => IsAllowedPageCmsResourceFind::class,
                        'validator-attributes' => IdAttributeZfInputFilterService::class,
                        'api' => FindPageCmsResource::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],

                // Find ContentVersion
                'zrcms.page.find-content-version.id' => [
                    'name' => 'zrcms.page.find-content-version.id',
                    'path' => '/zrcms/page/find-content-version/{id}',
                    'middleware' => [
                        'acl' => IsAllowedFindContentVersion::class,
                        'validator-attributes' => IdAttributeZfInputFilterService::class,
                        'api' => FindPageVersion::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
                */

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
