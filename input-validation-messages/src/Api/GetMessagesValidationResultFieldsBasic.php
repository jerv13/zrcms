<?php

namespace Zrcms\InputValidationMessages\Api;

use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\InputValidation\Model\ValidationResultFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetMessagesValidationResultFieldsBasic implements GetMessagesValidationResultFields
{
    const DEFAULT_MESSAGE = 'Value is invalid';

    protected $getMessagesValidationResult;
    protected $codeMessages;
    protected $defaultMessage;

    /**
     * @param GetMessagesValidationResult $getMessagesValidationResult
     * @param array                       $codeMessages
     * @param string                      $defaultMessage
     */
    public function __construct(
        GetMessagesValidationResult $getMessagesValidationResult,
        array $codeMessages,
        string $defaultMessage = self::DEFAULT_MESSAGE
    ) {
        $this->getMessagesValidationResult = $getMessagesValidationResult;
        $this->codeMessages = $codeMessages;
        $this->defaultMessage = $defaultMessage;
    }

    /**
     * @param ValidationResultFields $validationResultFields
     * @param array                  $options
     *
     * @return  array ['{field-name}' => ['{code}' => '{message}']]
     */
    public function __invoke(
        ValidationResultFields $validationResultFields,
        array $options = []
    ): array {
        $fieldResults = $validationResultFields->getFieldResults();

        return $this->buildMessagesValidationFields(
            $fieldResults,
            [],
            $options
        );
    }

    /**
     * @param array $fieldResults
     * @param array $messages
     * @param array $options
     *
     * @return array
     */
    public function buildMessagesValidationFields(
        array $fieldResults,
        array $messages = [],
        array $options = []
    ): array {
        foreach ($fieldResults as $fieldName => $validationResult) {
            $messages = $this->buildMessages(
                $fieldName,
                $validationResult,
                $messages,
                $options
            );
        }

        return $messages;
    }

    /**
     * @param string           $fieldName
     * @param ValidationResult $validationResult
     * @param array            $messages
     * @param array            $options
     *
     * @return array
     */
    public function buildMessages(
        string $fieldName,
        ValidationResult $validationResult,
        array $messages = [],
        array $options = []
    ): array {
        if ($validationResult instanceof ValidationResultFields) {
            $subMessages = $this->buildMessagesValidationFields(
                $validationResult->getFieldResults(),
                [],
                $options
            );

            $messages = $this->flattenSubMessages(
                $fieldName,
                $subMessages,
                $messages
            );

            return $messages;
        }

        $messages[$fieldName] = $this->getMessagesValidationResult->__invoke(
            $validationResult,
            $options
        );

        return $messages;
    }

    /**
     * @param string $fieldName
     * @param array  $subMessages
     * @param array  $messages
     *
     * @return array
     */
    protected function flattenSubMessages(
        string $fieldName,
        array $subMessages,
        array $messages
    ): array {
        foreach ($subMessages as $subFieldName => $subFieldMessages) {
            $fieldNamePath = $this->buildFieldName($fieldName, $subFieldName);

            $messages[$fieldNamePath] = $subFieldMessages;
        }

        return $messages;
    }

    /**
     * @param string $fieldName
     * @param string $subFieldName
     *
     * @return string
     */
    protected function buildFieldName(
        string $fieldName,
        string $subFieldName
    ): string {
        $stripped = trim($subFieldName, ']');

        $parts = explode('[', $stripped);

        $composite = $fieldName;

        foreach ($parts as $part) {
            $composite .= '[' . $part . ']';
        }

        return $composite;
    }
}
