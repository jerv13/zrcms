<?php

namespace Zrcms\HttpApi\Params;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zrcms\Http\Api\QueryParamValueDecode;
use Zrcms\Http\Model\HttpOrderBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiOrderBy implements MiddlewareInterface
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
        $orderBy = Property::getArray(
            $queryParams,
            HttpOrderBy::PARAM,
            null
        );

        if (!is_array($orderBy)) {
            return $delegate->process($request);
        }

        $orderBy = $this->queryParamValueDecode->__invoke($orderBy);

        return $delegate->process(
            $request->withAttribute(
                HttpOrderBy::ATTRIBUTE,
                $orderBy
            )
        );
    }
}
