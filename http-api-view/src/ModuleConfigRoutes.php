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
                'zrcms.view.{host}.{path:.*}' => [
                    'name' => 'zrcms.view.{host}.{path:.*}',
                    'path' => '/zrcms/view/{host}/{path:.*}',
                    'middleware' => [
                        //'acl' => HttpApiIsAllowedGetViewData::class,
                        'api' => HttpApiGetViewData::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET']
                ]
            ],
        ];
    }
}
