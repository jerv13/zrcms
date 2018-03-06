<?php

namespace Zrcms\HttpApiFields;

use Zrcms\HttpApiFields\Acl\HttpApiIsAllowedApiFindFieldsByModel;
use Zrcms\HttpApiFields\Acl\HttpApiIsAllowedApiFindFieldsByModelFactory;
use Zrcms\HttpApiFields\Acl\HttpApiIsAllowedFindFieldType;
use Zrcms\HttpApiFields\Acl\HttpApiIsAllowedFindFieldTypeFactory;
use Zrcms\HttpApiFields\Acl\HttpApiIsAllowedListFieldTypes;
use Zrcms\HttpApiFields\Acl\HttpApiIsAllowedListFieldTypesFactory;
use Zrcms\HttpApiFields\Field\HttpApiFindFieldsByModel;
use Zrcms\HttpApiFields\Field\HttpApiFindFieldsByModelFactory;
use Zrcms\HttpApiFields\Field\HttpApiFindFieldTypes;
use Zrcms\HttpApiFields\Field\HttpApiFindFieldTypesFactory;

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
                    HttpApiIsAllowedApiFindFieldsByModel::class => [
                        'factory' => HttpApiIsAllowedApiFindFieldsByModelFactory::class
                    ],
                    HttpApiIsAllowedFindFieldType::class => [
                        'factory' => HttpApiIsAllowedFindFieldTypeFactory::class
                    ],
                    HttpApiIsAllowedListFieldTypes::class => [
                        'factory' => HttpApiIsAllowedListFieldTypesFactory::class
                    ],

                    HttpApiFindFieldsByModel::class => [
                        'factory' => HttpApiFindFieldsByModelFactory::class
                    ],
                    HttpApiFindFieldTypes::class => [
                        'factory' => HttpApiFindFieldTypesFactory::class
                    ],
                ],
            ],
        ];
    }
}
