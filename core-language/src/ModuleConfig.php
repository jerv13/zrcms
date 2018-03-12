<?php

namespace Zrcms\CoreLanguage;

use Zrcms\CoreLanguage\Api\GetDefaultLanguage;
use Zrcms\CoreLanguage\Api\GetDefaultLanguageConfigFactory;

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
                    GetDefaultLanguage::class => [
                        'factory' => GetDefaultLanguageConfigFactory::class
                    ],
                ],
            ],
        ];
    }
}
