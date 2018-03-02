<?php

namespace Zrcms\ValidationRatZrcms\Api\FieldValidator;

use Reliv\FieldRat\Api\FieldValidator\ValidateFieldsByFieldsModelName;
use Reliv\ValidationRat\Api\FieldValidator\ValidateFields;
use Reliv\ValidationRat\Model\ValidationResultFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateFieldsContentVersionProperties implements ValidateFields
{
    const OPTION_FIELDS_MODEL_NAME = ValidateFieldsByFieldsModelName::OPTION_FIELDS_MODEL_NAME;

    protected $validateFieldsByFieldsModelName;

    /**
     * @param ValidateFields $validateFieldsByFieldsModelName
     */
    public function __construct(
        ValidateFields $validateFieldsByFieldsModelName
    ) {
        $this->validateFieldsByFieldsModelName = $validateFieldsByFieldsModelName;
    }

    /**
     * @param array $properties
     * @param array $options
     *
     * @return ValidationResultFields
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        array $properties,
        array $options = []
    ): ValidationResultFields {
        return $this->validateFieldsByFieldsModelName->__invoke(
            $properties,
            $options
        );
    }
}
