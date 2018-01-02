<?php

namespace Zrcms\HttpAssetsApplicationState\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zrcms\CoreApplicationState\Api\GetApplicationState;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ApplicationState
{
    protected $getApplicationState;

    /**
     * @param GetApplicationState $getApplicationState
     */
    public function __construct(
        GetApplicationState $getApplicationState
    ) {
        $this->getApplicationState = $getApplicationState;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return JsonResponse
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        return new JsonResponse(
            $this->getApplicationState->__invoke($request)
        );
    }
}
