<?php

namespace Zrcms\CoreApplication\Api\Component;

use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\Core\Fields\FieldsComponentConfig;
use Zrcms\Core\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindComponentBasic implements FindComponent
{
    protected $findComponentsByBasic;

    /**
     * @param FindComponentsByBasic $findComponentsByBasic
     */
    public function __construct(
        FindComponentsByBasic $findComponentsByBasic
    ) {
        $this->findComponentsByBasic = $findComponentsByBasic;
    }

    /**
     * @param string $type
     * @param string $name
     * @param array  $options
     *
     * @return null|Component
     * @throws \Exception
     */
    public function __invoke(
        string $type,
        string $name,
        array $options = []
    ) {
        $result = $this->findComponentsByBasic->__invoke(
            [
                FieldsComponentConfig::TYPE => $type,
                FieldsComponentConfig::NAME => $name
            ]
        );

        if (count($result) > 0) {
            return $result[0];
        }

        return null;
    }
}
