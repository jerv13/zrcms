<?php

namespace Zrcms\Logger;

use Zrcms\Logger\Api\Log;
use Zrcms\Logger\Api\LogBasic;
use Zrcms\Logger\Service\Logger;
use Zrcms\Logger\Service\LoggerComposite;
use Zrcms\Logger\Service\LoggerFile;
use Zrcms\Logger\Service\LoggerNoop;

/**
 * @author James Jervis - https://github.com/jerv13
 */
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
                    Log::class => [
                        'class' => LogBasic::class,
                        'arguments' => [
                            LoggerComposite::class,
                        ]
                    ],

                    Logger::class => [
                        'class' => LoggerNoop::class,
                    ],

                    LoggerComposite::class => [
                        'calls' => [
                            ['add', [LoggerFile::class]],
                        ]
                    ],

                    LoggerFile::class => [
                        'arguments' => [
                            ['literal' => __DIR__ . '\..\..\..\..\..\data\zrcms']
                        ]
                    ],
                ],
            ],
        ];
    }
}
