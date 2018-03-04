<?php

namespace Zrcms\ValidationRatZrcms;

use Zrcms\ValidationRatZrcms\Api\FieldValidator\BuildFieldValidationResults;
use Zrcms\ValidationRatZrcms\Api\FieldValidator\BuildFieldValidationResultsServicesFactory;
use Zrcms\ValidationRatZrcms\Api\FieldValidator\ValidateFieldsContentVersionProperties;
use Zrcms\ValidationRatZrcms\Api\FieldValidator\ValidateFieldsContentVersionPropertiesFactory;
use Zrcms\ValidationRatZrcms\Api\FieldValidator\ValidateFieldsInsertContentVersionData;
use Zrcms\ValidationRatZrcms\Api\FieldValidator\ValidateFieldsInsertContentVersionDataFactory;
use Zrcms\ValidationRatZrcms\Api\FieldValidator\ValidateFieldsUpsertCmsResourceData;
use Zrcms\ValidationRatZrcms\Api\FieldValidator\ValidateFieldsUpsertCmsResourceDataFactory;
use Zrcms\ValidationRatZrcms\Api\Validator\ValidateCmsResourceId;
use Zrcms\ValidationRatZrcms\Api\Validator\ValidateCmsResourceIdFactory;
use Zrcms\ValidationRatZrcms\Api\Validator\ValidateContentVersionExists;
use Zrcms\ValidationRatZrcms\Api\Validator\ValidateContentVersionExistsFactory;
use Zrcms\ValidationRatZrcms\Api\Validator\ValidateContentVersionId;
use Zrcms\ValidationRatZrcms\Api\Validator\ValidateContentVersionIdFactory;
use Zrcms\ValidationRatZrcms\Api\Validator\ValidateId;
use Zrcms\ValidationRatZrcms\Api\Validator\ValidateIdBasicFactory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    /**
                     * FieldsValidator
                     */
                    BuildFieldValidationResults::class => [
                        'factory' => BuildFieldValidationResultsServicesFactory::class,
                    ],
                    ValidateFieldsInsertContentVersionData::class => [
                        'factory' => ValidateFieldsInsertContentVersionDataFactory::class,
                    ],
                    ValidateFieldsContentVersionProperties::class => [
                        'factory' => ValidateFieldsContentVersionPropertiesFactory::class,
                    ],
                    ValidateFieldsUpsertCmsResourceData::class => [
                        'factory' => ValidateFieldsUpsertCmsResourceDataFactory::class,
                    ],

                    /**
                     * Validator
                     */
                    ValidateCmsResourceId::class => [
                        'factory' => ValidateCmsResourceIdFactory::class
                    ],
                    ValidateContentVersionExists::class => [
                        'factory' => ValidateContentVersionExistsFactory::class
                    ],
                    ValidateContentVersionId::class => [
                        'factory' => ValidateContentVersionIdFactory::class
                    ],
                    ValidateId::class => [
                        'factory' => ValidateIdBasicFactory::class,
                    ],
                ],
            ],
        ];
    }
}
