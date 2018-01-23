<?php

namespace Zrcms\Json;

use Zrcms\Json\Api\JsonDecode;
use Zrcms\Json\Api\JsonDecodeBasicFactory;
use Zrcms\Json\Api\JsonEncode;
use Zrcms\Json\Api\JsonEncodeBasicFactory;

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
                    JsonDecode::class => [
                        'factory' => JsonDecodeBasicFactory::class,
                    ],
                    JsonEncode::class => [
                        'factory' => JsonEncodeBasicFactory::class,
                    ],
                ],
            ],
        ];
    }
}
