<?php

namespace Zrcms\HttpApi\Params;

use Psr\Container\ContainerInterface;
use Zrcms\Http\Api\QueryParamValueDecode;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiWhereFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiWhere
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiWhere(
            $serviceContainer->get(QueryParamValueDecode::class)
        );
    }
}
