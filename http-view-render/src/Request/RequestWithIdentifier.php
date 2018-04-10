<?php

namespace Zrcms\HttpViewRender\Request;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreApplication\Api\GetGuidV4;

/**
 * Creates a unique ID for usages like caching against the request
 *
 * @author James Jervis - https://github.com/jerv13
 */
class RequestWithIdentifier implements MiddlewareInterface
{
    const ATTRIBUTE_REQUEST_ID = 'zrcms-request-id';

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return mixed|ResponseInterface
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        $request = $request->withAttribute(
            self::ATTRIBUTE_REQUEST_ID,
            GetGuidV4::invoke()
        );

        return $delegate->process($request);
    }
}
