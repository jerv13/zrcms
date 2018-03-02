<?php

namespace Zrcms\ValidationRatZrcms\Api\Validator;

use Reliv\ArrayProperties\Property;
use Reliv\FieldRat\Api\BuildFieldRatValidationOptions;
use Reliv\FieldRat\Model\FieldConfig;
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
            self::OPTION_FIELD_CONFIG,
            []
        );

        $fieldConfigOptions = Property::getArray(
            $fieldConfig,
            FieldConfig::OPTIONS,
            []
        );

        // Namespace might be available if this is a field type (field-rat) validation
        $fieldConfigNamespace = Property::getArray(
            $fieldConfigOptions,
            self::OPTION_SERVICE_ALIAS_NAMESPACE,
            []
        );

        $namespace = Property::getString(
            $options,
            self::OPTION_SERVICE_ALIAS_NAMESPACE,
            $fieldConfigNamespace
        );

        if (empty($namespace)) {
            throw new \Exception(
                'Service Alias namespace is required'
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
