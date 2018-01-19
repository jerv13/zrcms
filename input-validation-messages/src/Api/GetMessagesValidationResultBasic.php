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

        $message = Param::get(
            $this->codeMessages,
            $code,
            $this->defaultMessage
        );

        $message = $this->parseMessage(
            $message,
            $this->getMessageParams($validationResult, $options)
        );

        return [
            'code' => $code,
            'message' => $message
        ];
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
}
