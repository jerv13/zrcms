<?php

namespace Zrcms\ServiceAlias\Api;

use Psr\Container\ContainerInterface;
use Zrcms\ServiceAlias\Exception\ServiceAliasNotFoundException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetServiceFromAliasBasic implements GetServiceFromAlias
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var GetServiceName
     */
    protected $getServiceName;

    /**
     * @param                $serviceContainer
     * @param GetServiceName $getServiceName
     */
    public function __construct(
        $serviceContainer,
        GetServiceName $getServiceName
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->getServiceName = $getServiceName;
    }

    /**
     * NOTE: This enforces that service MUST have aliases to be used
     *       This keeps collisions from happening
     *
     * @param string $namespace
     * @param string $serviceAlias
     * @param string $interfaceClass
     * @param string $defaultServiceName
     * @param array  $options
     *
     * @return object
     */
    public function __invoke(
        string $namespace,
        string $serviceAlias,
        string $interfaceClass,
        string $defaultServiceName,
        array $options = []
    ) {
        $serviceName = $this->getServiceName->__invoke(
            $namespace,
            $serviceAlias,
            $defaultServiceName
        );

        if (!$this->serviceContainer->has($serviceName)) {
            new ServiceAliasNotFoundException(
                "Service not found: ({$serviceName})"
                . " with alias: ({$serviceAlias})"
                . " with default service: ({$defaultServiceName})"
                . " of interface: ({$interfaceClass})"
            );
        }

        $service = $this->serviceContainer->get($serviceName);

        if (!$service instanceof $interfaceClass) {
            new ServiceAliasNotFoundException(
                "Service not instance of interface: ({$interfaceClass})"
                . " with alias: ({$serviceAlias})"
                . " with default service: ({$defaultServiceName})"
                . " and service: ({$serviceName})"
            );
        }

        return $service;
    }
}
