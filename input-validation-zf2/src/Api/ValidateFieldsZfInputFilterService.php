<?php

namespace Zrcms\InputValidationZf2\Api;

use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use ZfInputFilterService\InputFilter\ServiceAwareInputFilter;
use Zrcms\InputValidation\Api\ValidateFields;
use Zrcms\InputValidation\Model\ValidationResultFields;
use Zrcms\Param\Param;

/**
 * @todo   Finish this
 *
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateFieldsZfInputFilterService implements ValidateFields
{
    const OPTION_INPUT_FILTER_SERVICE_CONFIG = 'input-filter-config';

    protected $factory;
    protected $validationResultFieldsFromZf2InputFilter;

    /**
     * @param ServiceAwareFactory                      $factory
     * @param ValidationResultFieldsFromZf2InputFilter $validationResultFieldsFromZf2InputFilter
     */
    public function __construct(
        ServiceAwareFactory $factory,
        ValidationResultFieldsFromZf2InputFilter $validationResultFieldsFromZf2InputFilter
    ) {
        $this->factory = $factory;
        $this->validationResultFieldsFromZf2InputFilter = $validationResultFieldsFromZf2InputFilter;
    }

    /**
     * @param array $fields
     * @param array $options
     *
     * @return ValidationResultFields
     * @throws \Throwable
     * @throws \Zrcms\Param\Exception\ParamException
     */
    public function __invoke(
        array $fields,
        array $options = []
    ): ValidationResultFields {
        $inputFilterConfig = Param::getRequired(
            $options,
            static::OPTION_INPUT_FILTER_SERVICE_CONFIG
        );

        $serviceAwareInputFilter = new ServiceAwareInputFilter(
            $this->factory,
            $inputFilterConfig
        );

        $serviceAwareInputFilter->setData($fields);

        $valid = $serviceAwareInputFilter->isValid($fields);

        return $this->validationResultFieldsFromZf2InputFilter->__invoke(
            $valid,
            $serviceAwareInputFilter,
            $fields
        );
    }
}
