<?php

namespace Zrcms\InputValidation\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateCompositeByStrategyFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ValidateCompositeByStrategy
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ValidateCompositeByStrategy(
            $serviceContainer->get(ValidateByStrategy::class)
        );
    }
}
