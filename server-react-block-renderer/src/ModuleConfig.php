<?php

namespace Zrcms\ServerReactBlockRenderer;

use Zrcms\CoreBlock\Model\ServiceAliasBlock;

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
            'zrcmsServerReactBlockRenderer' => [
                //Override this in your app with a real URL
                'remoteRenderApiUrl' => 'https://0.0.0.0/zrcms-server-react-block-renderer/render-block',
                'ignoreSSLErrors' => false
            ],
            'dependencies' => [
                'config_factories' => [
                    RenderBlockServerReact::class => [
                        'arguments' => [
                            ['from_config' => ['zrcmsServerReactBlockRenderer', 'remoteRenderApiUrl']],
                            ['from_config' => ['zrcmsServerReactBlockRenderer', 'ignoreSSLErrors']],
                        ]
                    ]
                ]
            ],
            'zrcms-service-alias' => [
                //Inject our block renderer in ZRCMS so it becomes available
                ServiceAliasBlock::ZRCMS_CONTENT_RENDERER => [
                    'serverReact' => RenderBlockServerReact::class
                ]
            ]
        ];
    }
}
