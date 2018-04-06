<?php

namespace Zrcms\HttpApi\Params;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zrcms\Http\Model\HttpLimit;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiLimit implements MiddlewareInterface
{
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
        $queryParams = $request->getQueryParams();

        $limit = Property::getInt(
            $queryParams,
            HttpLimit::PARAM,
            null
        );

        if ($limit === null) {
            return $delegate->process($request);
        }

        return $delegate->process(
            $request->withAttribute(
                HttpLimit::ATTRIBUTE,
                (int)$limit
            )
        );
    }
}
