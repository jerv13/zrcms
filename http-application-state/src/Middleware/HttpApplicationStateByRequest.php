<?php

namespace Zrcms\HttpApplicationState\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zend\Diactoros\Response\JsonResponse;
use Zrcms\CoreApplicationState\Api\GetApplicationState;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApplicationStateByRequest implements MiddlewareInterface
{
    const PARAM_APPLICATION_STATE = 'application-state';

    protected $getApplicationState;
    protected $debug;

    /**
     * @param GetApplicationState $getApplicationState
     * @param bool                $debug
     */
    public function __construct(
        GetApplicationState $getApplicationState,
        bool $debug = false
    ) {
        $this->getApplicationState = $getApplicationState;
        $this->debug = $debug;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface|JsonResponse
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        $params = $request->getQueryParams();
        $returnAppState = Property::getBool(
            $params,
            static::PARAM_APPLICATION_STATE,
            false
        );

        if ($returnAppState) {
            return new JsonResponse(
                $this->getApplicationState->__invoke($request),
                200,
                [],
                ($this->debug ? JSON_PRETTY_PRINT : 0)
            );
        }

        return $delegate->process($request);
    }
}
