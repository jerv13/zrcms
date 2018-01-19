<?php

namespace Zrcms\HttpAssetsApplicationState\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Uri;
use Zrcms\CoreApplicationState\Api\GetApplicationState;
use Zrcms\Http\Api\BuildMessageValue;
use Zrcms\Http\Response\ZrcmsJsonResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApplicationState
{
    const ATTRIBUTE_HOST = 'host';
    const ATTRIBUTE_PATH = 'path';

    const SOURCE_MISSING_HOST = 'missing-host';
    const NAME = 'application-state';

    protected $getApplicationState;
    protected $notFoundStatus;
    protected $badRequestStatus;
    protected $debug;

    /**
     * @param GetApplicationState $getApplicationState
     * @param int                 $notFoundStatus
     * @param int                 $badRequestStatus
     * @param bool                $debug
     */
    public function __construct(
        GetApplicationState $getApplicationState,
        int $notFoundStatus = 404,
        int $badRequestStatus = 400,
        bool $debug = false
    ) {
        $this->getApplicationState = $getApplicationState;
        $this->notFoundStatus = $notFoundStatus;
        $this->badRequestStatus = $badRequestStatus;
        $this->debug = $debug;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return ZrcmsJsonResponse|JsonResponse
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        $host = $request->getAttribute(static::ATTRIBUTE_HOST);
        $path = $request->getAttribute(static::ATTRIBUTE_PATH, '');

        $encodingOptions = 0;

        if ($this->debug) {
            $encodingOptions = JSON_PRETTY_PRINT;
        }

        $path = '/' . $path;

        if (empty($host)) {
            return new ZrcmsJsonResponse(
                null,
                BuildMessageValue::invoke(
                    (string)$this->badRequestStatus,
                    'BAD REQUEST',
                    static::NAME,
                    static::SOURCE_MISSING_HOST
                ),
                $this->notFoundStatus,
                [],
                [
                    ZrcmsJsonResponse::OPTION_JSON_FLAGS => $encodingOptions
                ]
            );
        }

        $uri = new Uri(
            'https://' . $host . $path
        );

        $fakeRequest = $request->withUri(
            $uri
        );

        return new JsonResponse(
            $this->getApplicationState->__invoke($fakeRequest),
            200,
            [],
            ($this->debug ? JSON_PRETTY_PRINT : 0)
        );
    }
}
