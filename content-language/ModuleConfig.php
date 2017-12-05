<?php

namespace Zrcms\ContentLanguage;

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
                'basic.zrcms-languages' => [
                    FieldsComponentRegistry::TYPE => '',
                    FieldsComponentRegistry::NAME => '',
                    FieldsComponentRegistry::CONFIG_LOCATION
                    => __DIR__ . '/basic.json',
                ],
            ],
        ];
    }
}
