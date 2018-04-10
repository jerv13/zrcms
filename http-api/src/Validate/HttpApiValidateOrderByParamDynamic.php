<?php

namespace Zrcms\HttpApi\Validate;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiValidateOrderByParamDynamic implements MiddlewareInterface
{
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
        // @todo Write this
        return $delegate->process($request);
    }
}
