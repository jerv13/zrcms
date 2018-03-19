<?php

namespace Zrcms\HttpApiBlockRender;

use Zrcms\HttpApiBlockRender\Acl\IsAllowedBlockRender;
use Zrcms\HttpApiBlockRender\Acl\IsAllowedBlockRenderFactory;
use Zrcms\HttpApiBlockRender\Middleware\HttpApiBlockRender;
use Zrcms\HttpApiBlockRender\Middleware\HttpApiBlockRenderFactory;
use Zrcms\HttpApiBlockRender\Validate\HttpApiValidateFieldsBlockVersionFieldModel;
use Zrcms\HttpApiBlockRender\Validate\HttpApiValidateFieldsBlockVersionFieldModelFactory;

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
                    IsAllowedBlockRender::class => [
                        'factory' => IsAllowedBlockRenderFactory::class,
                    ],

                    HttpApiBlockRender::class => [
                        'factory' => HttpApiBlockRenderFactory::class,
                    ],

                    HttpApiValidateFieldsBlockVersionFieldModel::class => [
                        'factory' => HttpApiValidateFieldsBlockVersionFieldModelFactory::class,
                    ],
                ],
            ],
        ];
    }
}
