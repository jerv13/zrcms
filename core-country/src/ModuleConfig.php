<?php

namespace Zrcms\CoreCountry;

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
                'basic.zrcms-countries' => [
                    FieldsComponentRegistry::TYPE => 'basic',
                    FieldsComponentRegistry::NAME => 'zrcms-countries',
                    FieldsComponentRegistry::CONFIG_LOCATION => __DIR__ . '/../zrcms-component.json',
                    FieldsComponentRegistry::MODULE_DIRECTORY
                    => __DIR__ . '/..',
                ],
            ],
        ];
    }
}
