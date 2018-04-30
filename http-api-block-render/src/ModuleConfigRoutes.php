<?php

namespace Zrcms\HttpApiBlockRender;

use Zrcms\Http\Response\JsonBodyParser;
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
                        'body-parser' => JsonBodyParser::class,
                        'fields-validator' => HttpApiValidateFieldsBlockVersionFieldModel::class,
                        'render' => HttpApiBlockRender::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['POST'],
                    'swagger' => [
                        'post' => [
                            'description' => 'Return full render data',
                            'produces' => [
                                'application/json',
                            ],
                            'parameters' => [
                                [
                                    'name' => 'block-id',
                                    'in' => 'query',
                                    'description' => 'Optional block id',
                                    'required' => false,
                                    'type' => 'string',
                                    'format' => 'string',
                                ],
                            ],
                            'responses' => [
                                'default' => [
                                    '$ref' => '#/definitions/ZrcmsJsonResponse'
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
