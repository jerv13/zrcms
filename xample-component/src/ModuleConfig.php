<?php

namespace Zrcms\XampleComponent;

use Zrcms\XampleComponent\View\Api\Render\GetViewLayoutTags;

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
                    GetViewLayoutTags::class => [],
                ],
            ],
        ];
    }
}
