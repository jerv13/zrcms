<?php

namespace Zrcms\HttpViewRender;

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
            /**
             * ===== ZRCMS Render Layout for Routes =====
             */
            'zrcms-http-render-layout-routes' => [
                /*
                '{name}' => [
                    'name' => '{name}',
                    'path' => '{path}',
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
                 */
            ],
        ];
    }
}
