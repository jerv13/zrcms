<?php

namespace Zrcms\HttpApi\Params;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zrcms\Http\Model\HttpOffset;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiOffset implements MiddlewareInterface
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

        $offset = Property::getInt(
            $queryParams,
            HttpOffset::PARAM,
            null
        );

        if ($offset === null) {
            return $delegate->process($request);
        }

        return $delegate->process(
            $request->withAttribute(
                HttpOffset::ATTRIBUTE,
                (int)$offset
            )
        );
    }
}
