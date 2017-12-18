<?php

namespace Zrcms\CoreLanguage;

use Zrcms\Core\Fields\FieldsComponentRegistry;

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
            'zrcms-components' => [
                'basic.zrcms-languages'
                => 'json:' . __DIR__ . '/../zrcms-component.json',
            ],
        ];
    }
}
