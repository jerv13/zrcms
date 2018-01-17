<?php

namespace Zrcms\HttpApi\Params;

use Psr\Container\ContainerInterface;
use Zrcms\Http\Api\QueryParamValueDecode;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiOrderByFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiOrderBy
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiOrderBy(
            $serviceContainer->get(QueryParamValueDecode::class)
        );
    }
}
