<?php

namespace Zrcms\HttpSiteMap;

use Zrcms\Acl\Api\IsAllowedAny;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourcesBy;
use Zrcms\CoreSite\Api\GetSiteCmsResourceByRequest;
use Zrcms\HttpSiteMap\Middleware\SiteMap;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    SiteMap::class => [
                        'arguments' => [
                            GetSiteCmsResourceByRequest::class,
                            FindPageCmsResourcesBy::class,
                            IsAllowedAny::class, // over-ride me
                        ],
                    ],
                ],
            ],
        ];
    }
}
