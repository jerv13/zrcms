<?php

namespace Zrcms\ServiceAlias\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Param\Param;
use Zrcms\ServiceAlias\Exception\ServiceAliasNotFoundException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetServiceBasic implements GetService
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
     * @param ContainerInterface $serviceContainer
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
     * @param string $type
     * @param string $serviceAlias
     * @param string $interfaceClass
     * @param string $defaultServiceName
     * @param array  $options
     *
     * @return string
     */
    public function __invoke(
        string $type,
        string $serviceAlias,
        string $interfaceClass,
        string $defaultServiceName,
        array $options = []
    ): string
    {
        $serviceName = $this->getServiceName->__invoke(
            $type,
            $serviceAlias,
            $defaultServiceName
        );

        if (!$this->serviceContainer->has($serviceName)) {
            new ServiceAliasNotFoundException(
                "Service not found: ({$serviceName})"
                . " for type: ({$type})"
                . " with alias: ({$serviceAlias})"
                . " with default service: ({$defaultServiceName})"
                . " of interface: ({$interfaceClass})"
            );
        }

        $service = $this->serviceContainer->get($serviceName);

        if (!$service instanceof $interfaceClass) {
            new ServiceAliasNotFoundException(
                "Service not instance of interface: ({$interfaceClass})"
                . " for type: ({$type})"
                . " with alias: ({$serviceAlias})"
                . " with default service: ({$defaultServiceName})"
                . " and service: ({$serviceName})"
            );
        }

        return $service;
    }
}
