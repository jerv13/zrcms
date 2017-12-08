<?php

namespace Zrcms\CoreApplication\Api\Component;

use Zrcms\Core\Api\Component\ReadComponentRegistry;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentRegistryBasic implements ReadComponentRegistry
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
