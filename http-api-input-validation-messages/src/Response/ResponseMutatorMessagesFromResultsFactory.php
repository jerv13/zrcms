<?php

namespace Zrcms\HttpApiInputValidationMessages\Api\Response;

use Psr\Container\ContainerInterface;
use Zrcms\InputValidationMessages\Api\GetMessagesValidationResult;
use Zrcms\InputValidationMessages\Api\GetMessagesValidationResultFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ResponseMutatorMessagesFromResultsFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ResponseMutatorMessagesFromResults
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ResponseMutatorMessagesFromResults(
            $serviceContainer->get(GetMessagesValidationResult::class),
            $serviceContainer->get(GetMessagesValidationResultFields::class),
            ['application/json', 'json']
        );
    }
}