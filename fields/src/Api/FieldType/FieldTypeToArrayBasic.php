<?php

namespace Zrcms\Fields\Api\FieldType;

use Zrcms\Fields\Model\FieldType;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldTypeToArrayBasic implements FieldTypeToArray
{
    /**
     * @param FieldType $fieldType
     * @param array     $options
     *
     * @return array
     */
    public function __invoke(
        FieldType $fieldType,
        array $options = []
    ): array {
        return [
            'type' => $fieldType->getType(),
            'properties' => $fieldType->getProperties(),
        ];
    }
}
