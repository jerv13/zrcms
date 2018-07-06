<?php

namespace Zrcms\ClientReactBlockRenderer;

use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\CoreBlock\Api\Render\FilterWithWhitelistInterface;
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
            'dependencies' => [
                'config_factories' => [
                    RenderBlockClientReact::class => []
                ]
            ],
            'zrcms-service-alias' => [
                //Inject our block renderer in ZRCMS so it becomes available
                ServiceAliasBlock::ZRCMS_CONTENT_RENDERER => [
                    'clientReact' => RenderBlockClientReact::class
                ]
            ]
        ];
    }
}
