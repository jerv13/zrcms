<?php

namespace Zrcms\HttpApiSite;

use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;
use Zrcms\CoreSite\Api\CmsResource\UpsertSiteCmsResource;
use Zrcms\HttpApi\Validate\HttpApiIdAttributeZfInputFilterServiceHttpApi;
use Zrcms\HttpApiSite\Acl\HttpApiIsAllowedFindContentVersionIsAllowed;
use Zrcms\HttpApiSite\Acl\HttpApiIsAllowedSiteCmsResourceFindIsAllowed;
use Zrcms\HttpApiSite\Acl\HttpApiIsAllowedSitePublishIsAllowed;
use Zrcms\HttpApiSite\CmsResource\HttpApiFindSiteCmsResource;
use Zrcms\HttpApiSite\Content\HttpApiFindSiteVersion;
use Zrcms\HttpApiSite\Validate\HttpApiUpsertSiteCmsResourceZfInputFilterServiceHttpApi;

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
                'zrcms.site.cms-resource' => [
                    'name' => 'zrcms.site.cms-resource',
                    'path' => '/zrcms/site/cms-resource',
                    'middleware' => [
                        'parser' => BodyParamsMiddleware::class,
                        'acl' => HttpApiIsAllowedSitePublishIsAllowed::class,
                        'validator-data' => HttpApiUpsertSiteCmsResourceZfInputFilterServiceHttpApi::class,
                        'api' => UpsertSiteCmsResource::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['PUT'],
                ],

                'zrcms.site.find-cms-resource.id' => [
                    'name' => 'zrcms.site.find-cms-resource.id',
                    'path' => '/zrcms/site/find-cms-resource/{id}',
                    'middleware' => [
                        'acl' => HttpApiIsAllowedSiteCmsResourceFindIsAllowed::class,
                        'validator-attributes' => HttpApiIdAttributeZfInputFilterServiceHttpApi::class,
                        'api' => HttpApiFindSiteCmsResource::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],

                'zrcms.site.find-content-version.id' => [
                    'name' => 'zrcms.site.find-content-version.id',
                    'path' => '/zrcms/site/find-content-version/{id}',
                    'middleware' => [
                        'acl' => HttpApiIsAllowedFindContentVersionIsAllowed::class,
                        'validator-attributes' => HttpApiIdAttributeZfInputFilterServiceHttpApi::class,
                        'api' => HttpApiFindSiteVersion::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],
        ];
    }
}
