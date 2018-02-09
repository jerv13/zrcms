<?php

namespace Zrcms\HttpApi\Params;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Http\Api\QueryParamValueDecode;
use Zrcms\Http\Model\HttpWhere;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiWhere
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
        $where = Property::getArray(
            $queryParams,
            HttpWhere::PARAM,
            null
        );

        if (!is_array($where)) {
            return $next($request, $response);
        }

        $where = $this->queryParamValueDecode->__invoke($where);

        return $next(
            $request->withAttribute(
                HttpWhere::ATTRIBUTE,
                $where
            ),
            $response
        );
    }
}
