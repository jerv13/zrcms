<?php

namespace Zrcms\InputValidation\Api;

use Zrcms\InputValidation\Model\ValidationResultBasic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildFieldNotRecognizedResult
{
    const OPTION_UNRECOGNIZED_FIELD_CODE = 'code-unrecognized-field';

    const CODE_UNRECOGNIZED_FIELD = 'unrecognized-field';

    /**
     * @param string $fieldName
     * @param array  $options
     *
     * @return ValidationResultBasic
     */
    public static function invoke(
        string $fieldName,
        array $options = []
    ) {
        return new ValidationResultBasic(
            false,
            Param::getString(
                $options,
                self::OPTION_UNRECOGNIZED_FIELD_CODE,
                self::CODE_UNRECOGNIZED_FIELD
            ),
            ['message' => 'Unrecognized field received: (' . $fieldName . ')']
        );
    }

    /**
     * @param string $fieldName
     * @param array  $options
     *
     * @return ValidationResultBasic
     */
    public function __invoke(
        string $fieldName,
        array $options = []
    ) {
        return self::invoke(
            $fieldName,
            $options
        );
    }
}
