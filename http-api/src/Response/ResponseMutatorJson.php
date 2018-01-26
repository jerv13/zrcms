<?php

namespace Zrcms\HttpApi\Response;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zrcms\Http\Api\BuildMessageValue;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Api\IsValidAcceptType;
use Zrcms\Http\Response\ZrcmsJsonResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ResponseMutatorJson
{
    protected $validAcceptTypes;
    protected $statusBlackList;
    protected $debug;

    /**
     * @param array $validAcceptTypes
     * @param array $statusBlackList
     * @param bool  $debug
     */
    public function __construct(
        array $validAcceptTypes = ['application/json', 'json'],
        array $statusBlackList = [200, 201, 204, 301, 302],
        bool $debug = false
    ) {
        $this->validAcceptTypes = $validAcceptTypes;
        $this->statusBlackList = $statusBlackList;
        $this->debug = $debug;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        /** @var JsonResponse $response */
        $response = $next($request, $response);

        if (!$this->canHandleResponse($request, $response)) {
            return $response;
        }

        $statusCode = $response->getStatusCode();

        if ($statusCode == 200 && empty($response->getBody()->getContents())) {
            // @todo 204 No Content
            $statusCode = 404;
        };

        $jsonResponse = new ZrcmsJsonResponse(
            null,
            BuildMessageValue::invoke(
                'empty',
                'No Response',
                'response',
                'zrcms-response-mutator'
            ),
            $statusCode,
            [],
            BuildResponseOptions::invoke()
        );

        if ($this->debug) {
            return $jsonResponse->withAddedHeader('zrcms-response-mutator', 'ResponseMutatorJson');
        }

        return $jsonResponse;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     *
     * @return bool
     */
    protected function canHandleResponse(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): bool {

        if (!IsValidAcceptType::invoke($request, $this->validAcceptTypes)) {
            return false;
        }
        // @todo This empty body check should not be required
        if (!empty($response->getBody()->getContents())) {
            return false;
        }

        if (in_array($response->getStatusCode(), $this->statusBlackList)) {
            return false;
        }

        return true;
    }
}
