<?php

namespace Zrcms\HttpApiBlockRender;

use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;
use Zrcms\HttpApiBlockRender\Acl\IsAllowedBlockRender;
use Zrcms\HttpApiBlockRender\Middleware\HttpApiBlockRender;
use Zrcms\HttpApiBlockRender\Validate\HttpApiValidateFieldsBlockVersionFieldModel;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigRoutes
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'routes' => [
                'zrcms.api.content-version.block.render' => [
                    'name' => 'zrcms.api.content-version.block.render',
                    'path' => '/zrcms/api/content-version/block/render',
                    'middleware' => [
                        'acl' => IsAllowedBlockRender::class,
                        'body-parser' => BodyParamsMiddleware::class,
                        'fields-validator' => HttpApiValidateFieldsBlockVersionFieldModel::class,
                        'render' => HttpApiBlockRender::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['POST'],
                ],
            ],
        ];
    }
}
