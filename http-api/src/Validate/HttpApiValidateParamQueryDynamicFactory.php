<?php

namespace Zrcms\HttpApi\Validate;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiValidateParamQueryDynamicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiValidateParamQueryDynamic
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiValidateParamQueryDynamic();
    }
}
