<?php

namespace Zrcms\HttpExpressive1\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\HttpExpressive1\Model\RequestAttributes;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ParamQuery
{
    const PARAM_WHERE = 'where';
    const PARAM_ORDER_BY = 'orderby';
    const PARAM_LIMIT = 'limit';
    const PARAM_OFFSET = 'offset';

    /**
     * __invoke
     *
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

        // @todo Security and preparation
        $where = Param::getArray(
            $queryParams,
            self::PARAM_WHERE,
            []
        );

        $orderBy = Param::getInt(
            $queryParams,
            self::PARAM_ORDER_BY,
            null
        );

        $limit = Param::getInt(
            $queryParams,
            self::PARAM_LIMIT,
            null
        );

        $offset = Param::getInt(
            $queryParams,
            self::PARAM_OFFSET,
            null
        );

        $response = $request->withAttribute(
            RequestAttributes::QUERY_WHERE,
            $where
        )->withAttribute(
            RequestAttributes::QUERY_ORDER_BY,
            $orderBy
        )->withAttribute(
            RequestAttributes::QUERY_LIMIT,
            $limit
        )->withAttribute(
            RequestAttributes::QUERY_OFFSET,
            $offset
        );

        return $next($request, $response);
    }
}
