<?php

namespace Zrcms\HttpViewRender\Request;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RequestWithOriginalUri implements MiddlewareInterface
{
    const ATTRIBUTE_ORIGINAL_URI = 'zrcms-original-uri';

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        $request = $request->withAttribute(
            self::ATTRIBUTE_ORIGINAL_URI,
            $request->getUri()
        );

        return $delegate->process($request);
    }
}
