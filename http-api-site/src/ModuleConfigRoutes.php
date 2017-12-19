<?php

namespace Zrcms\HttpApiSite;

use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;
use Zrcms\CoreSite\Api\CmsResource\UpsertSiteCmsResource;
use Zrcms\HttpApi\Validate\IdAttributeZfInputFilterService;
use Zrcms\HttpApiSite\Acl\IsAllowedFindContentVersion;
use Zrcms\HttpApiSite\Acl\IsAllowedSiteCmsResourceFind;
use Zrcms\HttpApiSite\Acl\IsAllowedSitePublish;
use Zrcms\HttpApiSite\CmsResource\FindSiteCmsResource;
use Zrcms\HttpApiSite\Content\FindSiteVersion;
use Zrcms\HttpApiSite\Validate\UpsertSiteCmsResourceZfInputFilterService;

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
                // Upsert CmsResource
                'zrcms.site.cms-resource' => [
                    'name' => 'zrcms.site.cms-resource',
                    'path' => '/zrcms/site/cms-resource',
                    'middleware' => [
                        'parser' => BodyParamsMiddleware::class,
                        'acl' => IsAllowedSitePublish::class,
                        'validator-data' => UpsertSiteCmsResourceZfInputFilterService::class,
                        'api' => UpsertSiteCmsResource::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['PUT'],
                ],

                // Find CmsResource
                'zrcms.site.repository.find-cms-resource.id' => [
                    'name' => 'zrcms.site.repository.find-cms-resource.id',
                    'path' => '/zrcms/site/repository/find-cms-resource/{id}',
                    'middleware' => [
                        'acl' => IsAllowedSiteCmsResourceFind::class,
                        'validator-attributes' => IdAttributeZfInputFilterService::class,
                        'api' => FindSiteCmsResource::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],

                // Find ContentVersion
                'zrcms.site.repository.find-content-version.id' => [
                    'name' => 'zrcms.site.repository.find-content-version.id',
                    'path' => '/zrcms/site/repository/find-content-version/{id}',
                    'middleware' => [
                        'acl' => IsAllowedFindContentVersion::class,
                        'validator-attributes' => IdAttributeZfInputFilterService::class,
                        'api' => FindSiteVersion::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],
        ];
    }
}
