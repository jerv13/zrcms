<?php

namespace Zrcms\InputValidationMessages\Api;

use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetMessagesValidationResultBasic implements GetMessagesValidationResult
{
    const DEFAULT_MESSAGE = 'Value is invalid';

    protected $codeMessages;
    protected $defaultMessage;

    /**
     * @param array  $codeMessages
     * @param string $defaultMessage
     */
    public function __construct(
        array $codeMessages,
        string $defaultMessage = self::DEFAULT_MESSAGE
    ) {
        $this->codeMessages = $codeMessages;
        $this->defaultMessage = $defaultMessage;
    }

    /**
     * @param ValidationResult $validationResult
     * @param array            $options
     *
     * @return array ['{code}' => '{message}']
     */
    public function __invoke(
        ValidationResult $validationResult,
        array $options = []
    ): array {
        $code = $validationResult->getCode();

        // We don not care about validity, only if there is a code
        if (empty($code)) {
            return [];
        }

        $message = $this->getMessage($code, $options);

        $message = $this->parseMessage(
            $message,
            $this->getMessageParams($validationResult, $options)
        );

        return [
            GetMessagesValidationResult::KEY_CODE => $code,
            GetMessagesValidationResult::KEY_MESSAGE => $message,
        ];
    }

    /**
     * @param string $code
     * @param array  $options
     *
     * @return string
     */
    protected function getMessage(
        string $code,
        array $options
    ): string {
        $message = Param::get(
            $this->codeMessages,
            $code
        );

        if (empty($message)) {
            return $this->defaultMessage;
        }

        if (is_string($message)) {
            return $message;
        }

        if (!is_array($message)) {
            return $this->defaultMessage;
        }

        $fieldName = Param::getString(
            $options,
            static::KEY_FIELD_NAME
        );

        if (empty($fieldName)) {
            // Default message
            return Param::getString(
                $message,
                static::KEY_DEFAULT,
                $this->defaultMessage
            );
        }

        $fieldMessage = Param::getString(
            $message,
            $fieldName
        );

        if (!empty($fieldMessage)) {
            return $fieldMessage;
        }

        // Default message
        return Param::getString(
            $message,
            static::KEY_DEFAULT,
            $this->defaultMessage
        );
    }

    /**
     * @param string $message
     * @param array  $messageParams
     *
     * @return string
     */
    protected function parseMessage(
        string $message,
        array $messageParams
    ): string {
        foreach ($messageParams as $param => $messageParam) {
            $message = str_replace(
                '{' . $param . '}',
                $messageParam,
                $message
            );
        }

        return $message;
    }

    /**
     * @param ValidationResult $validationResult
     * @param array            $options
     *
     * @return array|null
     */
    protected function getMessageParams(
        ValidationResult $validationResult,
        array $options = []
    ) {
        $messageParams = Param::getArray(
            $options,
            static::OPTION_MESSAGE_PARAMS,
            []
        );

        $messageParams = array_merge(
            $messageParams,
            Param::getArray(
                $validationResult->getDetails(),
                static::OPTION_MESSAGE_PARAMS,
                []
            )
        );

        return $messageParams;
    }
}
