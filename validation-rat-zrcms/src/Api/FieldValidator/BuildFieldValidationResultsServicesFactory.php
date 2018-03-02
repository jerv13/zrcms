<?php

namespace Zrcms\ValidationRatZrcms\Api\FieldValidator;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildFieldValidationResultsServicesFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return BuildFieldValidationResultsServices
     */
    public function __invoke(ContainerInterface $serviceContainer)
    {
        return new BuildFieldValidationResultsServices(
            $serviceContainer
        );
    }
}
