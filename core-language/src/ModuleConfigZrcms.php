<?php

namespace Zrcms\CoreLanguage;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigZrcms
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
