<?php

namespace Zrcms\HttpResponseHandler\Api;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HandleResponseReturnOnStatus implements HandleResponse
{
    protected $successStatuses = [];

    public function __construct(
        $successStatuses = [200]
    ) {
        $this->successStatuses = $successStatuses;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     * @param array                  $options
     *
     * @return mixed
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null,
        array $options = []
    ) {
        $status = $response->getStatusCode();
        if (in_array($status, $this->successStatuses)) {
            return $response;
        }
        // clear any strangeness
        $response = new Response();

        return $next($request, $response);
    }
}
