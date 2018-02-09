<?php

namespace Zrcms\ValidationRatZrcms;

use Zrcms\ValidationRatZrcms\Api\ValidateCmsResourceDataUpsert;
use Zrcms\ValidationRatZrcms\Api\ValidateCmsResourceDataUpsertFactory;
use Zrcms\ValidationRatZrcms\Api\ValidateContentVersionDataInsert;
use Zrcms\ValidationRatZrcms\Api\ValidateContentVersionDataFactory;
use Zrcms\ValidationRatZrcms\Api\ValidateId;
use Zrcms\ValidationRatZrcms\Api\ValidateIdBasicFactory;
use Zrcms\ValidationRatZrcms\Api\ValidateProperties;
use Zrcms\ValidationRatZrcms\Api\ValidatePropertiesFactory;

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
