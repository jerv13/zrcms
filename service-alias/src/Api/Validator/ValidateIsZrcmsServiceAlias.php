<?php

namespace Zrcms\ServiceAlias\Api\Validator;

use Reliv\ArrayProperties\Property;
use Reliv\FieldRat\Api\BuildFieldRatValidationOptions;
use Reliv\FieldRat\Model\FieldConfig;
use Reliv\Json\Json;
use Reliv\ValidationRat\Api\Validator\Validate;
use Reliv\ValidationRat\Model\ValidationResult;
use Reliv\ValidationRat\Model\ValidationResultBasic;
use Zrcms\ServiceAlias\Api\GetServiceAliasRegistry;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateIsZrcmsServiceAlias implements Validate
{
    const OPTION_FIELD_CONFIG = BuildFieldRatValidationOptions::OPTION_FIELD_CONFIG;
    const VALIDATOR_OPTION_FIELD_CONFIG = BuildFieldRatValidationOptions::VALIDATOR_OPTION_FIELD_CONFIG;
    const OPTION_SERVICE_ALIAS_NAMESPACE = 'zrcms-service-alias-namespace';

    const CODE_MUST_BE_STRING = 'zrcms-service-alias-must-be-string';
    const CODE_MUST_BE_ZRCMS_SERVICE_ALIAS = 'must-be-zrcms-service-alias';

    protected $getServiceAliasRegistry;

    /**
     * @param GetServiceAliasRegistry $getServiceAliasRegistry
     */
    public function __construct(
        GetServiceAliasRegistry $getServiceAliasRegistry
    ) {
        $this->getServiceAliasRegistry = $getServiceAliasRegistry;
    }

    /**
     * @param mixed $value
     * @param array $options
     *
     * @return ValidationResult
     * @throws \Throwable
     */
    public function __invoke(
        $value,
        array $options = []
    ): ValidationResult {
        if (!is_string($value)) {
            return new ValidationResultBasic(
                false,
                static::CODE_MUST_BE_STRING
            );
        }

        $fieldConfig = Property::getArray(
            $options,
            self::VALIDATOR_OPTION_FIELD_CONFIG,
            []
        );

        $fieldConfigOptions = Property::getArray(
            $fieldConfig,
            FieldConfig::OPTIONS,
            []
        );

        // Namespace might be available from field config if this is a field type (field-rat) validation
        $namespace = Property::getString(
            $fieldConfigOptions,
            self::OPTION_SERVICE_ALIAS_NAMESPACE,
            null
        );

        if (empty($namespace)) {
            // If the 'validator-options' have namespace, use them
            $namespace = Property::getString(
                $options,
                self::OPTION_SERVICE_ALIAS_NAMESPACE,
                null
            );
        }

        if (empty($namespace)) {
            throw new \Exception(
                'Service Alias namespace is required for validator-options or field-config options: '
                . Json::encode($options)
            );
        }

        $registry = $this->getServiceAliasRegistry->__invoke();

        $namespaceRegistry = Property::getArray(
            $registry,
            $namespace,
            null
        );

        if (empty($namespaceRegistry)) {
            return new ValidationResultBasic(
                false,
                static::CODE_MUST_BE_ZRCMS_SERVICE_ALIAS
            );
        }

        return new ValidationResultBasic();
    }
}
