<?php

namespace Zrcms\HttpApi\Params;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Http\Api\QueryParamValueDecode;
use Zrcms\Http\Model\HttpOrderBy;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiOrderBy
{
    protected $queryParamValueDecode;

    /**
     * @param QueryParamValueDecode $queryParamValueDecode
     */
    public function __construct(
        QueryParamValueDecode $queryParamValueDecode
    ) {
        $this->queryParamValueDecode = $queryParamValueDecode;
    }

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

        // @todo Security
        $orderBy = Property::getArray(
            $queryParams,
            HttpOrderBy::PARAM,
            null
        );

        if (!is_array($orderBy)) {
            return $next($request, $response);
        }

        $orderBy = $this->queryParamValueDecode->__invoke($orderBy);

        return $next(
            $request->withAttribute(
                HttpOrderBy::ATTRIBUTE,
                $orderBy
            ),
            $response
        );
    }
}
