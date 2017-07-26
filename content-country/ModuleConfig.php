<?php

namespace Zrcms\ContentCountry;

use Zrcms\ContentCountry\Api\Action\PublishCountryCmsResource;
use Zrcms\ContentCountry\Api\Action\UnpublishCountryCmsResource;
use Zrcms\ContentCountry\Api\Repository\FindCountryCmsResource;
use Zrcms\ContentCountry\Api\Repository\FindCountryCmsResourceByIso3;
use Zrcms\ContentCountry\Api\Repository\FindCountryCmsResourcesBy;
use Zrcms\ContentCountry\Api\Repository\FindCountryVersion;
use Zrcms\ContentCountry\Api\Repository\FindCountryVersionsBy;
use Zrcms\ContentCountry\Api\Repository\InsertCountryVersion;
use Zrcms\Core\ApiNoop;

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
                    PublishCountryCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            ['literal' => PublishCountryCmsResource::class],
                        ],
                    ],
                    UnpublishCountryCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            ['literal' => UnpublishCountryCmsResource::class],
                        ],
                    ],
                    FindCountryCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            ['literal' => FindCountryCmsResource::class],
                        ],
                    ],
                    FindCountryCmsResourceByIso3::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            ['literal' => FindCountryCmsResourceByIso3::class],
                        ],
                    ],
                    FindCountryCmsResourcesBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            ['literal' => FindCountryCmsResourcesBy::class],
                        ],
                    ],
                    FindCountryVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            ['literal' => FindCountryVersion::class],
                        ],
                    ],
                    FindCountryVersionsBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            ['literal' => UnpublishCountryCmsResource::class],
                        ],
                    ],
                    InsertCountryVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            ['literal' => UnpublishCountryCmsResource::class],
                        ],
                    ],
                ],
            ],
        ];
    }
}
