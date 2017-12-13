<?php

namespace Zrcms\HttpCorePage;

use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourcesBy;
use Zrcms\CoreSite\Api\GetSiteCmsResourceByRequest;
use Zrcms\HttpCorePage\Middleware\SiteMap;

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
                        ],
                    ],
                ],
            ],
        ];
    }
}
