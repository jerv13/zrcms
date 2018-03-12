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
            'zrcms-language-default' => [
                'iso639_2t' => 'eng',
                'iso639_2b' => 'eng',
                'iso639_1' => 'en',
                'name' => 'English'
            ],
            'zrcms-components' => [
                'basic.zrcms-languages'
                => 'json:' . __DIR__ . '/../zrcms-component.json',
            ],
        ];
    }
}
