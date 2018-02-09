<?php

namespace Zrcms\HttpApi\Params;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Http\Model\HttpOffset;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiOffset
{
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
        $queryParams = $request->getQueryParams();

        $offset = Property::getInt(
            $queryParams,
            HttpOffset::PARAM,
            null
        );

        if ($offset === null) {
            return $next($request, $response);
        }

        return $next(
            $request->withAttribute(
                HttpOffset::ATTRIBUTE,
                (int)$offset
            ),
            $response
        );
    }
}
