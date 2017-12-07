<?php

namespace Zrcms\ContentCountry;

use Zrcms\Content\Fields\FieldsComponentRegistry;

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
                    FieldsComponentRegistry::CONFIG_LOCATION => __DIR__ . '/basic.json',
                    FieldsComponentRegistry::MODULE_DIRECTORY
                    => __DIR__,
                ],
            ],
        ];
    }
}
