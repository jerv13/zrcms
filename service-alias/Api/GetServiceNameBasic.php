<?php

namespace Zrcms\ServiceAlias\Api;

use Zrcms\Param\Param;
use Zrcms\ServiceAlias\Exception\ServiceAliasNotFound;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetServiceNameBasic implements GetServiceName
{
    protected $registry;

    /**
     * @param array $registry
     */
    public function __construct(
        array $registry
    ) {
        $this->registry = $registry;
    }

    /**
     * @param string $namespace
     * @param string $serviceAlias
     * @param string $defaultServiceName
     * @param array  $options
     *
     * @return string
     * @throws ServiceAliasNotFound
     */
    public function __invoke(
        string $namespace,
        string $serviceAlias,
        string $defaultServiceName,
        array $options = []
    ): string {
        if (empty($serviceAlias)) {
            return $defaultServiceName;
        }

        $namespaceRegistry = Param::getArray(
            $this->registry,
            $namespace,
            []
        );

        if (empty($namespaceRegistry)) {
            // @todo Logger::warning())
            trigger_error(
                "Namespace registry not defined for namespace: ({$namespace}) "
                . " with service alias ({$serviceAlias})"
                . " used service: ({$defaultServiceName})",
                E_USER_WARNING
            );
            return $defaultServiceName;
        }

        $serviceName = Param::getString(
            $namespaceRegistry,
            $serviceAlias,
            $defaultServiceName
        );

        if (empty($serviceName)) {
            // @todo Logger::warning()
            trigger_error(
                "Service alias not defined: ({$serviceAlias}) "
                . " with namespace ({$namespace})"
                . " used service: ({$defaultServiceName})",
                E_USER_WARNING
            );
            return $defaultServiceName;
        }

        return $serviceName;
    }
}
