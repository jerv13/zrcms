<?php

namespace Zrcms\HttpApiSwagger;

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
             * ===== HTTP API Swagger =====
             */
            'http-api-swagger' => [
                'swagger' => '2.0',
                'info' => [
                    'version' => '1.0.0',
                    'title' => 'ZRCMS',
                    'description' => 'ZRCMS APIs',
                    //'contact' => ['name' => '',],
                    //'license' => ['name' => '',],
                ],
                'host' => '',
                'basePath' => '/',
                'schemes' => ['https',],
                'consumes' => ['application/json',],
                'produces' => ['application/json',],
                'paths' => [
                ],
                'definitions' => [
                    'Swagger' => [
                        'type' => 'object',
                        'properties' => [
                            'swagger' => [
                                'type' => 'string',
                                'format' => 'string',
                            ],
                            'info' => [
                                'type' => 'object',
                                'format' => 'object',
                            ],
                            'host' => [
                                'type' => 'string',
                                'format' => 'string',
                            ],
                            'basePath' => [
                                'type' => 'string',
                                'format' => 'string',
                            ],
                            'schemes' => [
                                'type' => 'array',
                                'format' => 'array',
                            ],
                            'consumes' => [
                                'type' => 'array',
                                'format' => 'array',
                            ],
                            'produces' => [
                                'type' => 'array',
                                'format' => 'array',
                            ],
                            'paths' => [
                                'type' => 'object',
                                'format' => 'object',
                            ],
                            'definitions' => [
                                'type' => 'object',
                                'format' => 'object',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
