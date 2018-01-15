<?php

namespace Zrcms\CoreApplication\Api\Component;

use Zrcms\Core\Api\Component\ComponentsToArray;
use Zrcms\Core\Api\Component\ComponentToArray;
use Zrcms\Core\Model\Component;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ComponentsToArrayBasic implements ComponentsToArray
{
    protected $componentToArray;

    /**
     * @param ComponentToArray $componentToArray
     */
    public function __construct(
        ComponentToArray $componentToArray
    ) {
        $this->componentToArray = $componentToArray;
    }

    /**
     * @param Component[] $components
     * @param array       $options
     *
     * @return array
     */
    public function __invoke(
        array $components,
        array $options = []
    ): array {
        $array = [];

        foreach ($components as $component) {
            $array[] = $this->componentToArray->__invoke(
                $component,
                Param::getArray(
                    $options,
                    self::OPTION_COMPONENT_OPTIONS,
                    []
                )
            );
        }

        return $array;
    }
}
