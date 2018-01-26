<?php

namespace Zrcms\HttpApiView;

use Zrcms\HttpApiView\Acl\HttpApiIsAllowedGetViewData;
use Zrcms\HttpApiView\Content\HttpApiGetViewData;

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
                'zrcms.api.view.{host}.{path:.*}' => [
                    'name' => 'zrcms.api.view.{host}.{path:.*}',
                    'path' => '/zrcms/api/view/{host}/{path:.*}',
                    'middleware' => [
                        'acl' => HttpApiIsAllowedGetViewData::class,
                        'api' => HttpApiGetViewData::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET']
                ]
            ],
        ];
    }
}
