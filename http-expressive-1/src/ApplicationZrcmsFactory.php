<?php

namespace Zrcms\HttpExpressive1;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\Container\ApplicationFactory;
use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\RouterInterface;
use Zrcms\HttpExpressive1\HttpResponseMutator\ResponseMutator;

/**
 * @todo This does not work
 * @see \Zend\Expressive\Container\ApplicationFactory
 */
class ApplicationZrcmsFactory extends ApplicationFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return ApplicationZrcms
     */
    public function __invoke(ContainerInterface $container)
    {
        // @todo This is done because the parent is not well abstracted an has private functions
        /** @var Application $expressiveApp */
        $expressiveApp = parent::__invoke($container);

        $router = $container->has(RouterInterface::class)
            ? $container->get(RouterInterface::class)
            : new FastRouteRouter();

        $responseMutator = $container->has(ResponseMutator::class)
            ? $container->get(ResponseMutator::class)
            : null;

        return new ApplicationZrcms(
            $router,
            $container,
            $expressiveApp->getDefaultDelegate(),
            $expressiveApp->getEmitter(),
            $responseMutator
        );
    }
}

