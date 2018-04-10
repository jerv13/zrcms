<?php

namespace Zrcms\HttpApplicationState\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Uri;
use Zrcms\CoreApplicationState\Api\GetApplicationState;
use Zrcms\Http\Api\BuildMessageValue;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApplicationState implements MiddlewareInterface
{
    const ATTRIBUTE_HOST = 'zrcms-application-state-host';
    const ATTRIBUTE_PATH = 'zrcms-application-state-path';

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
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface|ZrcmsJsonResponse
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        $host = $request->getAttribute(static::ATTRIBUTE_HOST);
        $path = $request->getAttribute(static::ATTRIBUTE_PATH, '');

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
                BuildResponseOptions::invoke()
            );
        }

        $uri = new Uri(
            'https://' . $host . $path
        );

        $fakeRequest = $request->withUri(
            $uri
        );

        return new ZrcmsJsonResponse(
            $this->getApplicationState->__invoke($fakeRequest),
            null,
            200,
            [],
            BuildResponseOptions::invoke()
        );
    }
}
