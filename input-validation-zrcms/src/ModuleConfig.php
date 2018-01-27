<?php

namespace Zrcms\InputValidationZrcms;

use Zrcms\InputValidationZrcms\Api\ValidateCmsResourceDataUpsert;
use Zrcms\InputValidationZrcms\Api\ValidateCmsResourceDataUpsertFactory;
use Zrcms\InputValidationZrcms\Api\ValidateContentVersionDataInsert;
use Zrcms\InputValidationZrcms\Api\ValidateContentVersionDataFactory;
use Zrcms\InputValidationZrcms\Api\ValidateId;
use Zrcms\InputValidationZrcms\Api\ValidateIdBasicFactory;
use Zrcms\InputValidationZrcms\Api\ValidateProperties;
use Zrcms\InputValidationZrcms\Api\ValidatePropertiesFactory;

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
                    ValidateCmsResourceDataUpsert::class => [
                        'factory' => ValidateCmsResourceDataUpsertFactory::class,
                    ],
                    ValidateContentVersionDataInsert::class => [
                        'factory' => ValidateContentVersionDataFactory::class,
                    ],
                    ValidateId::class => [
                        'factory' => ValidateIdBasicFactory::class,
                    ],
                    ValidateProperties::class => [
                        'factory' => ValidatePropertiesFactory::class,
                    ],
                ],
            ],
        ];
    }
}
