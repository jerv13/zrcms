<?php

namespace Zrcms\Http\Response;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\Json\Json;
use Reliv\Json\JsonError;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class JsonBodyParser implements MiddlewareInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return \Psr\Http\Message\ResponseInterface|ZrcmsJsonResponse
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $rawBody = (string)$request->getBody();

        try {
            $parsedBody = Json::decode($rawBody, true);
        } catch (JsonError $exception) {
            return new ZrcmsJsonResponse(
                null,
                ['invalid-json' => 'Received invalid json'],
                400
            );
        }

        return $delegate->process($request->withParsedBody($parsedBody));
    }
}
