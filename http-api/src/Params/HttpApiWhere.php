<?php

namespace Zrcms\HttpApi\Params;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zrcms\Http\Api\QueryParamValueDecode;
use Zrcms\Http\Model\HttpWhere;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiWhere implements MiddlewareInterface
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
     * @param DelegateInterface      $delegate
     *
     * @return mixed|ResponseInterface
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        $queryParams = $request->getQueryParams();

        // @todo Security
        $where = Property::getArray(
            $queryParams,
            HttpWhere::PARAM,
            null
        );

        if (!is_array($where)) {
            return $delegate->process($request);
        }

        $where = $this->queryParamValueDecode->__invoke($where);

        return $delegate->process(
            $request->withAttribute(
                HttpWhere::ATTRIBUTE,
                $where
            )
        );
    }
}
