<?php

namespace Zrcms\HttpResponseHandler\Api;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;
use Zrcms\HttpResponseHandler\Exception\CanNotHandleResponse;
use Zrcms\HttpResponseHandler\Model\HandleResponseOptions;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HandleResponseNextOnError implements HandleResponse
{
    /**
     * @var array
     */
    protected $successStatuses = [];

    /**
     * @param array $successStatuses
     */
    public function __construct(
        array $successStatuses = [200]
    ) {
        $this->successStatuses = $successStatuses;
    }

    /**
     * @param ResponseInterface $response
     * @param array             $options
     *
     * @return ResponseInterface|Response
     * @throws CanNotHandleResponse
     */
    public function __invoke(
        ResponseInterface $response,
        array $options = []
    ) {
        $next = Param::get(
            $options,
            HandleResponseOptions::NEXT
        );

        $request = Param::get(
            $options,
            HandleResponseOptions::REQUEST
        );

        $status = $response->getStatusCode();

        $this->assertCanHandleResponse($status, $next, $request);

        // clear any strangeness
        $response = new Response();

        return $next($request, $response);
    }

    /**
     * @param int                   $status
     * @param callable|null         $next
     * @param RequestInterface|null $request
     *
     * @return void
     * @throws CanNotHandleResponse
     */
    public function assertCanHandleResponse(
        $status,
        $next,
        $request
    ) {
        if (in_array($status, $this->successStatuses)) {
            throw new CanNotHandleResponse(
                "Success status received: {$status}"
            );
        }

        if (!is_callable($next)) {
            throw new CanNotHandleResponse(
                "Next is not callable"
            );
        }

        if (!$request instanceof RequestInterface) {
            throw new CanNotHandleResponse(
                "Request is not valid"
            );
        }
    }
}
