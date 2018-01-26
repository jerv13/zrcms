<?php

namespace Zrcms\HttpApplicationState;

use Zrcms\CoreApplicationState\Api\Render\RenderScriptTagApplicationState;

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
            'zrcms-view-head.head-script' => [
                'sections' => [
                    'config' => [
                        'zrcms.application-state.js' => [
                            'renderer' => 'render-service',
                            '__render_service' => RenderScriptTagApplicationState::class,
                        ],
                    ],
                ],
            ],
        ];
    }
}
