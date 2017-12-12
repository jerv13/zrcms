<?php

namespace Zrcms\ServiceAlias\Api;

use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetServiceAliasesByNamespaceBasic implements GetServiceAliasesByNamespace
{
    protected $getServiceAliasRegistry;

    /**
     * @param GetServiceAliasRegistry $getServiceAliasRegistry
     */
    public function __construct(
        GetServiceAliasRegistry $getServiceAliasRegistry
    ) {
        $this->getServiceAliasRegistry = $getServiceAliasRegistry;
    }

    /**
     * @param string $namespace
     * @param array  $options
     *
     * @return array
     */
    public function __invoke(
        string $namespace,
        array $options = []
    ): array {
        $registry = $this->getServiceAliasRegistry->__invoke();

        return Param::getArray(
            $registry,
            $namespace,
            []
        );
    }
}
