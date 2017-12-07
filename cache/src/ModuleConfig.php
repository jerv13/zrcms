<?php

namespace Zrcms\Cache;

use Zrcms\Cache\Api\ClearCache;
use Zrcms\Cache\Api\ClearCacheBasic;
use Zrcms\Cache\Api\DeleteCacheValue;
use Zrcms\Cache\Api\DeleteCacheValueBasic;
use Zrcms\Cache\Api\DeleteCacheValues;
use Zrcms\Cache\Api\DeleteCacheValuesBasic;
use Zrcms\Cache\Api\GetCacheValue;
use Zrcms\Cache\Api\GetCacheValueBasic;
use Zrcms\Cache\Api\GetCacheValues;
use Zrcms\Cache\Api\GetCacheValuesBasic;
use Zrcms\Cache\Api\HasCacheValue;
use Zrcms\Cache\Api\HasCacheValueBasic;
use Zrcms\Cache\Api\SetCacheValue;
use Zrcms\Cache\Api\SetCacheValueBasic;
use Zrcms\Cache\Api\SetCacheValues;
use Zrcms\Cache\Api\SetCacheValuesBasic;
use Zrcms\Cache\Service\Cache;
use Zrcms\Cache\Service\CacheArray;

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
                    /**
                     * Api ===========================================
                     */
                    ClearCache::class => [
                        ClearCacheBasic::class,
                        'arguments' => [
                            Cache::class,
                        ],
                    ],
                    DeleteCacheValue::class => [
                        DeleteCacheValueBasic::class,
                        'arguments' => [
                            Cache::class,
                        ],
                    ],
                    DeleteCacheValues::class => [
                        DeleteCacheValuesBasic::class,
                        'arguments' => [
                            Cache::class,
                        ],
                    ],
                    GetCacheValue::class => [
                        GetCacheValueBasic::class,
                        'arguments' => [
                            Cache::class,
                        ],
                    ],
                    GetCacheValues::class => [
                        GetCacheValuesBasic::class,
                        'arguments' => [
                            Cache::class,
                        ],
                    ],
                    HasCacheValue::class => [
                        HasCacheValueBasic::class,
                        'arguments' => [
                            Cache::class,
                        ],
                    ],
                    SetCacheValue::class => [
                        SetCacheValueBasic::class,
                        'arguments' => [
                            Cache::class,
                        ],
                    ],
                    SetCacheValues::class => [
                        SetCacheValuesBasic::class,
                        'arguments' => [
                            Cache::class,
                        ],
                    ],
                    /**
                     * Service ===========================================
                     */
                    Cache::class => [
                        'class' => CacheArray::class,
                    ],
                    CacheArray::class => [],
                ],
            ],
            /** Register caches so global clears can be applied */
            'zrcms-caches' => [
                // @todo Implement this
            ],
        ];
    }
}
