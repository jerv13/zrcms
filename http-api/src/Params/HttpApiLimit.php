<?php

namespace Zrcms\HttpApi\Params;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Http\Model\HttpLimit;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiLimit
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

        $limit = Param::getInt(
            $queryParams,
            HttpLimit::PARAM,
            null
        );

        if ($limit === null) {
            return $next($request, $response);
        }

        return $next(
            $request->withAttribute(
                HttpLimit::ATTRIBUTE,
                (int)$limit
            ),
            $response
        );
    }
}
