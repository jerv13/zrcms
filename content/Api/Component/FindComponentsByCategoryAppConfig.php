<?php

namespace Zrcms\Content\Api\Component;

use Zrcms\Content\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindComponentsByCategoryAppConfig implements FindComponentsByCategory
{
    protected $readComponentRegistry;

    /**
     * @param ReadComponentRegistry $readComponentRegistry\
     */
    public function __construct(
        ReadComponentRegistry $readComponentRegistry
    ) {
        $this->readComponentRegistry = $readComponentRegistry;
    }

    /**
     * @param string $category
     * @param array  $options
     *
     * @return Component[]
     */
    public function __invoke(
        string $category,
        array $options = []
    ): array {
        $componentRegistry = $this->readComponentRegistry->__invoke();



    }
}
