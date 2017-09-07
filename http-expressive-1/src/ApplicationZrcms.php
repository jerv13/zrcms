<?php

namespace Zrcms\HttpExpressive1;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\EmitterInterface;
use Zend\Expressive\Application;
use Zend\Expressive\Router\RouterInterface;
use Zrcms\HttpExpressive1\HttpResponseMutator\ResponseMutator;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ApplicationZrcms extends Application
{
    /**
     * @var ResponseMutator|null
     */
    protected $responseMutator = null;

    /**
     * @param RouterInterface         $router
     * @param null|ContainerInterface $container       IoC container from which to pull services, if any.
     * @param null|callable           $finalHandler    Final handler to use when $out is not
     *                                                 provided on invocation.
     * @param null|EmitterInterface   $emitter         Emitter to use when `run()` is
     *                                                 invoked.
     * @param null|ResponseMutator    $responseMutator Handle Responses the ZRCMS way
     */
    public function __construct(
        RouterInterface $router,
        $container = null,
        $finalHandler = null,
        $emitter = null,
        $responseMutator = null
    ) {
        $this->responseMutator = $responseMutator;

        parent::__construct($router, $container, $finalHandler, $emitter);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $out
     *
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $out = null
    ) {
        $result = parent::__invoke($request, $response, $out);

        if ($result instanceof ResponseInterface && $this->responseMutator) {
            return $this->responseMutator->__invoke(
                $request,
                $result,
                $out
            );
        }

        return $result;
    }
}
