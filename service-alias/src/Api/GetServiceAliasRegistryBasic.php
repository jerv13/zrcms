<?php

namespace Zrcms\ServiceAlias\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetServiceAliasRegistryBasic implements GetServiceAliasRegistry
{
    protected $registry;

    /**
     * @param array $registry
     */
    public function __construct(array $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function __invoke(
        array $options = []
    ): array {
        return $this->registry;
    }
}
