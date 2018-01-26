<?php

namespace Zrcms\Fields\Api\Field;

use Zrcms\Fields\Model\Fields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FieldsToArray
{
    /**
     * @param Fields $fields
     * @param array  $options
     *
     * @return array
     */
    public function __invoke(
        Fields $fields,
        array $options = []
    ): array;
}
