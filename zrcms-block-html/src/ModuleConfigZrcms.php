<?php

namespace Zrcms\BlockHtml;

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
                'block.html.zrcms'
                => 'json:' . __DIR__ . '/../block/block.json',
            ],
        ];
    }
}
