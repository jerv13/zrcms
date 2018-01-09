<?php

namespace Zrcms\HttpApiView;

use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;
use Zrcms\HttpApiView\Content\GetViewByRequestHttpApi;
use Zrcms\HttpApiView\Content\IsAllowedGetViewByRequestHttpApi;

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
            ],
        ];
    }
}
