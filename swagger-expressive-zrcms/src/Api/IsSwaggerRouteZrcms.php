<?php

namespace Zrcms\SwaggerExpressiveZrcms\Api;

use Zrcms\SwaggerExpressive\Api\BuildRouteName;
use Zrcms\SwaggerExpressive\Api\IsSwaggerRoute;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsSwaggerRouteZrcms implements IsSwaggerRoute
{
    /**
     * @param mixed $key
     * @param array $routeData
     *
     * @return bool
     */
    public function __invoke(
        $key,
        array $routeData
    ): bool {
        $name = BuildRouteName::invoke(
            $key,
            $routeData
        );

        return (substr($name, 0, 10) === 'zrcms.api.');
    }
}
