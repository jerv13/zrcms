<?php

namespace Zrcms\InputValidationZf2\Api;

use Psr\Container\ContainerInterface;
use Zend\Validator\ValidatorInterface;
use Zrcms\InputValidation\Api\Validate;
use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\InputValidation\Model\ValidationResultBasic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateZf2 implements Validate
{
    const OPTION_NAME = 'name';
    const OPTION_ZEND_VALIDATOR = 'zend-validator';
    const OPTION_ZEND_VALIDATOR_IS_SERVICE = 'zend-validator-is-service';
    const OPTION_ZEND_VALIDATOR_OPTIONS = 'zend-validator-options';

    const DEFAULT_INVALID_CODE = 'invalid';

    protected $serviceContainer;
    protected $defaultInvalidCode;

    /**
     * @param ContainerInterface $serviceContainer
     * @param string             $defaultInvalidCode
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        string $defaultInvalidCode = self::DEFAULT_INVALID_CODE
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->defaultInvalidCode = $defaultInvalidCode;
    }

    /**
     * @param mixed $value
     * @param array $options
     *
     * @return ValidationResult
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     * @throws \Zrcms\Param\Exception\ParamException
     */
    public function __invoke(
        $value,
        array $options = []
    ): ValidationResult {
        $name = Param::getString(
            $options,
            static::OPTION_NAME,
            'default'
        );

        $validator = $this->getValidator(
            $options
        );

        $valid = $validator->isValid($value);

        // @todo ZF3 Validators may return a result object, deal with the result here

        $messages = $validator->getMessages();

        $result = new ValidationResultBasic(
            $valid,
            $this->buildCode($valid, $messages),
            [
                'zf2' => true,
                'messages-zf2' => $messages,
                'name' => $name,
                'validator-zf2' => get_class($validator),
            ]
        );

        return $result;
    }

    /**
     * @param array $options
     *
     * @return ValidatorInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     * @throws \Zrcms\Param\Exception\ParamException
     */
    protected function getValidator(
        array $options
    ): ValidatorInterface {
        $validator = Param::getRequired(
            $options,
            static::OPTION_ZEND_VALIDATOR
        );

        // NOTE: by default we will assume validator to be a service
        $validatorIsService = Param::getBool(
            $options,
            static::OPTION_ZEND_VALIDATOR_IS_SERVICE,
            true
        );

        $validatorOptions = Param::getArray(
            $options,
            static::OPTION_ZEND_VALIDATOR_OPTIONS,
            []
        );

        if ($validatorIsService) {
            /** @var \Zend\Validator\ValidatorInterface|\Zend\Validator\AbstractValidator $validatorService */
            $validatorService = $this->serviceContainer->get($validator);
            // We clone to deal with ZF2 stateful validators
            $validator = clone($validatorService);
        } else {
            /** @var \Zend\Validator\ValidatorInterface|\Zend\Validator\AbstractValidator $validator */
            $validator = new $validator();
        }

        if (method_exists($validator, 'setOptions')) {
            $validator->setOptions($validatorOptions);
        }

        return $validator;
    }

    /**
     * @param bool  $valid
     * @param array $messages
     *
     * @return string
     */
    protected function buildCode(bool $valid, array $messages)
    {
        if ($valid) {
            return '';
        }

        return $this->defaultInvalidCode;
    }
}
