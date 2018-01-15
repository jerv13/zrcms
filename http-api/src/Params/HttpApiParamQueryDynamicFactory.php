<?php

namespace Zrcms\HttpApi\Params;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiParamQueryDynamicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiParamQueryDynamic
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiParamQueryDynamic();
    }
}
