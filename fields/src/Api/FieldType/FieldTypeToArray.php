<?php

namespace Zrcms\Fields\Api\FieldType;

use Zrcms\Fields\Model\FieldType;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FieldTypeToArray
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
    ): array;
}
