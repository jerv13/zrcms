<?php

namespace Zrcms\HttpViewRender\Router;

use FastRoute\RouteCollector;
use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\Route;
use Reliv\Json\Json;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class LayoutThemeRouterFastRoute extends FastRouteRouter implements LayoutThemeRouter
{
    /**
     * @param array               $pageLayoutConfig
     * @param RouteCollector|null $router
     * @param callable|null       $dispatcherFactory
     * @param array|null          $config
     */
    public function __construct(
        array $pageLayoutConfig = [],
        RouteCollector $router = null,
        callable $dispatcherFactory = null,
        array $config = null
    ) {
        $this->addRoutesArray($pageLayoutConfig);

        parent::__construct(
            $router,
            $dispatcherFactory,
            $config
        );
    }

    /**
     * @param array $pageLayoutConfig
     *
     * @return void
     */
    protected function addRoutesArray(array $pageLayoutConfig)
    {
        foreach ($pageLayoutConfig as $spec) {
            if (!isset($spec['path'])) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Path is required',
                        Json::encode($pageLayoutConfig, 0, 3)
                    )
                );
            }

            $spec['middleware'] = function (){
                // do nothing - hack to avoid writing a new route object
            };

            $methods = Route::HTTP_METHOD_ANY;
            if (isset($spec['allowed_methods'])) {
                $methods = $spec['allowed_methods'];
                if (!is_array($methods)) {
                    throw new \InvalidArgumentException(
                        sprintf(
                            'Allowed HTTP methods for a route must be in form of an array; received "%s"',
                            gettype($methods)
                        )
                    );
                }
            }

            $name = isset($spec['name']) ? $spec['name'] : null;
            $route = new Route($spec['path'], $spec['middleware'], $methods, $name);

            if (isset($spec['options'])) {
                $options = $spec['options'];
                if (!is_array($options)) {
                    throw new \InvalidArgumentException(
                        sprintf(
                            'Route options must be an array; received "%s"',
                            gettype($options)
                        )
                    );
                }

                $route->setOptions($options);
            }

            $this->addRoute($route);
        }
    }
}
