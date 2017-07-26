<?php

namespace Zrcms\ContentCountryDoctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\ContentCountry\Api\Action\PublishCountryCmsResource;
use Zrcms\ContentCountry\Api\Action\UnpublishCountryCmsResource;
use Zrcms\ContentCountry\Api\Repository\FindCountryCmsResource;
use Zrcms\ContentCountry\Api\Repository\FindCountryCmsResourceByIso3;
use Zrcms\ContentCountry\Api\Repository\FindCountryCmsResourcesBy;
use Zrcms\ContentCountry\Api\Repository\FindCountryVersion;
use Zrcms\ContentCountry\Api\Repository\FindCountryVersionsBy;
use Zrcms\ContentCountry\Api\Repository\InsertCountryVersion;

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
                        'class' => \Zrcms\ContentCountryDoctrine\Api\Action\PublishCountryCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    UnpublishCountryCmsResource::class => [
                        'class' => \Zrcms\ContentCountryDoctrine\Api\Action\UnpublishCountryCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindCountryCmsResource::class => [
                        'class' => \Zrcms\ContentCountryDoctrine\Api\Repository\FindCountryCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindCountryCmsResourceByIso3::class => [
                        'class' => \Zrcms\ContentCountryDoctrine\Api\Repository\FindCountryCmsResourceByIso3::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindCountryCmsResourcesBy::class => [
                        'class' => \Zrcms\ContentCountryDoctrine\Api\Repository\FindCountryCmsResourcesBy::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindCountryVersion::class => [
                        'class' => \Zrcms\ContentCountryDoctrine\Api\Repository\FindCountryVersion::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindCountryVersionsBy::class => [
                        'class' => \Zrcms\ContentCountryDoctrine\Api\Repository\FindCountryVersionsBy::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    InsertCountryVersion::class => [
                        'class' => \Zrcms\ContentCountryDoctrine\Api\Repository\InsertCountryVersion::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                ],
            ],
            'doctrine' => [
                'driver' => [
                    ModuleConfig::class => [
                        'class' => AnnotationDriver::class,
                        'cache' => 'array',
                        'paths' => [
                            __DIR__ . '/../Entity',
                        ]
                    ],
                    'orm_default' => [
                        'drivers' => [
                            ModuleConfig::class => ModuleConfig::class
                        ]
                    ]
                ],
            ],
        ];
    }
}