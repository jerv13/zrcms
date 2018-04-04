<?php

namespace Zrcms\ThemeDefault;

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
                'theme.default'
                => 'json:' . __DIR__ . '/../theme/theme.json',
                'theme-layout.default.layout-one'
                => 'json:' . __DIR__ . '/../theme/layout-one/layout.json',
                'theme-layout.default.primary'
                => 'json:' . __DIR__ . '/../theme/layout-primary/layout.json',
            ],
        ];
    }
}
