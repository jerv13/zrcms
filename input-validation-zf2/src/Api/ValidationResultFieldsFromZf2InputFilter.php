<?php

namespace Zrcms\InputValidationZf2\Api;

use Zend\InputFilter\BaseInputFilter;
use Zend\InputFilter\CollectionInputFilter;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputInterface;
use ZfInputFilterService\InputFilter\ServiceAwareInputFilter;
use Zrcms\InputValidation\Model\ValidationResultFields;
use Zrcms\InputValidation\Model\ValidationResultFieldsBasic;

/**
 * @todo   Finish this
 *
 * @author James Jervis - https://github.com/jerv13
 */
class ValidationResultFieldsFromZf2InputFilter
{
    const DETAIL_RAW_RESULT = 'raw-result';
    const DETAIL_FILTER_RESULT = 'filter-result';

    protected $codeDefault = 'invalid';

    /**
     * @param bool                                                                     $valid
     * @param ServiceAwareInputFilter|InputFilter|BaseInputFilter|InputFilterInterface $inputFilter
     * @param null                                                                     $context
     *
     * @return ValidationResultFields
     */
    public function __invoke(
        bool $valid,
        InputFilterInterface $inputFilter,
        $context = null
    ): ValidationResultFields {
        $this->parseInputs($inputFilter);

        return new ValidationResultFieldsBasic(
            $valid,
            $this->buildCode($valid, $inputFilter, $context),
            $this->buildDetails($valid, $inputFilter, $context),
            $this->buildFieldResults($valid, $inputFilter, $context)
        );
    }

    /**
     * @param bool                 $valid
     * @param InputFilterInterface $inputFilter
     * @param null                 $context
     *
     * @return string
     */
    protected function buildCode(
        bool $valid,
        InputFilterInterface $inputFilter,
        $context = null
    ): string {
        $code = 'zf2';

        if ($valid) {
            return $code;
        }

        $code .= '-' . $this->codeDefault;

        return $code;
    }

    /**
     * @param bool                 $valid
     * @param InputFilterInterface $inputFilter
     * @param null                 $context
     *
     * @return array
     */
    protected function buildDetails(
        bool $valid,
        InputFilterInterface $inputFilter,
        $context = null
    ): array {
        return [
            static::DETAIL_RAW_RESULT => $inputFilter->getRawValues(),
            static::DETAIL_FILTER_RESULT => $inputFilter->getValues(),
        ];
    }

    /**
     * @param bool                 $valid
     * @param InputFilterInterface $inputFilter
     * @param null                 $context
     *
     * @return array
     */
    protected function buildFieldResults(
        bool $valid,
        InputFilterInterface $inputFilter,
        $context = null
    ): array {
        return [
            $messages => $inputFilter->getMessages()
        ];
    }

    /**
     * @param string     $name
     * @param string|int $key
     * @param object     $subInput
     *
     * @return string
     */
    protected function getParseName(
        $name,
        $key,
        $subInput
    ): string {
        $fieldName = $key;
        if (method_exists($subInput, 'getName')) {
            $fieldName = $subInput->getName();
        }
        if ($name !== '') {
            $fieldName = $name . '-' . $fieldName;
        }

        return $fieldName;
    }

    /**
     * parseInputs
     *
     * @param mixed  $input
     * @param string $name
     *
     * @return void
     */
    protected function parseInputs(
        $input,
        $name = ''
    ) {
        if (is_array($input)) {
            foreach ($input as $key => $subInput) {
                $fieldName = $this->getParseName($name, $key, $subInput);
                $this->parseInputs($subInput, $fieldName);
            }

            return;
        }

        if ($input instanceof CollectionInputFilter) {
            $inputs = $input->getInvalidInput();
            foreach ($inputs as $groupKey => $group) {
                $fieldName = $this->getParseName($name, $groupKey, $group);
                $this->parseInputs($group, $fieldName);
            }

            return;
        }

        if ($input instanceof InputFilterInterface) {
            $inputs = $input->getInvalidInput();

            foreach ($inputs as $key => $subInput) {
                $fieldName = $this->getParseName($name, $key, $subInput);
                $this->parseInputs($subInput, $fieldName);
            }

            return;
        }

        $this->buildValidatorMessages($name, $input);
    }

    /**
     * @param string         $fieldName
     * @param InputInterface $input
     *
     * @return array
     */
    protected function buildValidatorMessages(
        string $fieldName,
        InputInterface $input
    ): array {
        $validatorChain = $input->getValidatorChain();
        $validators = $validatorChain->getValidators();

        // We get the input messages because input does validations outside of the validators
        $allMessages = $input->getMessages();

        foreach ($validators as $validatorData) {
            /** @var \Zend\Validator\AbstractValidator $validator */
            $validator = $validatorData['instance'];

            $params = [];

            try {
                $messagesParams = $validator->getOption('messageParams');
                $params = array_merge(
                    $params,
                    $messagesParams
                );
            } catch (\Exception $exception) {
                // Do nothing
            }
            $inputMessages = $validator->getMessages();

            // Remove the messages from $allMessages as we get them from the validators
            $allMessages = array_diff($allMessages, $inputMessages);
        }

        return $allMessages;
    }
}
