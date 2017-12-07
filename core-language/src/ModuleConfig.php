<?php

namespace Zrcms\CoreLanguage;

use Zrcms\Core\Fields\FieldsComponentRegistry;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * __invoke
     *
     * @return array
     */
    public function __invoke()
    {

        return [
            'zrcms-components' => [
                'basic.zrcms-languages' => [
                    FieldsComponentRegistry::TYPE => 'basic',
                    FieldsComponentRegistry::NAME => 'zrcms-languages',
                    FieldsComponentRegistry::CONFIG_LOCATION
                    => __DIR__ . '/../zrcms-component.json',
                    FieldsComponentRegistry::MODULE_DIRECTORY
                    => __DIR__ . '/..',
                ],
            ],
        ];
    }
}
