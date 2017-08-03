<?php

namespace Zrcms\ServiceAlias\Api;

use Zrcms\Param\Param;
use Zrcms\ServiceAlias\Exception\ServiceAliasNotFoundException;

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
     * @param string $type
     * @param string $serviceAlias
     * @param string $defaultServiceName
     * @param array  $options
     *
     * @return string
     * @throws ServiceAliasNotFoundException
     */
    public function __invoke(
        string $type,
        string $serviceAlias,
        string $defaultServiceName,
        array $options = []
    ): string
    {
        $typeRegistry = Param::getArray(
            $this->registry,
            $type,
            []
        );

        if (empty($typeRegistry)) {
            // @todo Logger::warning())
            trigger_error(
                "Type registry not defined for type: ({$type}) "
                . " with service alias ({$serviceAlias})"
                . " used service: ({$defaultServiceName})",
                E_USER_WARNING
            );
            return $defaultServiceName;
        }

        $serviceName = Param::getString(
            $typeRegistry,
            $serviceAlias,
            $defaultServiceName
        );

        if (empty($serviceName)) {
            // @todo Logger::warning()
            trigger_error(
                "Type registry not defined for type: ({$type}) "
                . " with service alias ({$serviceAlias})"
                . " used service: ({$defaultServiceName})",
                E_USER_WARNING
            );
            return $defaultServiceName;
        }

        return $serviceName;
    }
}
