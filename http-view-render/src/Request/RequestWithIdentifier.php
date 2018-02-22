<?php

namespace Zrcms\HttpViewRender\Request;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreApplication\Api\GetGuidV4;

/**
 * Creates a unique ID for usages like caching against the request
 *
 * @author James Jervis - https://github.com/jerv13
 */
class RequestWithIdentifier
{
    const ATTRIBUTE_REQUEST_ID = 'zrcms-request-id';

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
        $request = $request->withAttribute(
            self::ATTRIBUTE_REQUEST_ID,
            GetGuidV4::invoke()
        );

        return $next($request, $response);
    }
}
