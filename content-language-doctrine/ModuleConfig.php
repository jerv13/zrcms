<?php

namespace Zrcms\ContentLanguageDoctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\ContentLanguage\Api\Action\PublishLanguageCmsResource;
use Zrcms\ContentLanguage\Api\Action\UnpublishLanguageCmsResource;
use Zrcms\ContentLanguage\Api\Repository\FindLanguageCmsResource;
use Zrcms\ContentLanguage\Api\Repository\FindLanguageCmsResourceByIso6392t;
use Zrcms\ContentLanguage\Api\Repository\FindLanguageCmsResourcesBy;
use Zrcms\ContentLanguage\Api\Repository\FindLanguageVersion;
use Zrcms\ContentLanguage\Api\Repository\FindLanguageVersionsBy;
use Zrcms\ContentLanguage\Api\Repository\InsertLanguageVersion;

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
                    PublishLanguageCmsResource::class => [
                        'class' => \Zrcms\ContentLanguageDoctrine\Api\Action\PublishLanguageCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    UnpublishLanguageCmsResource::class => [
                        'class' => \Zrcms\ContentLanguageDoctrine\Api\Action\UnpublishLanguageCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindLanguageCmsResource::class => [
                        'class' => \Zrcms\ContentLanguageDoctrine\Api\Repository\FindLanguageCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindLanguageCmsResourceByIso6392t::class => [
                        'class' => \Zrcms\ContentLanguageDoctrine\Api\Repository\FindLanguageCmsResourceByIso6392t::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindLanguageCmsResourcesBy::class => [
                        'class' => \Zrcms\ContentLanguageDoctrine\Api\Repository\FindLanguageCmsResourcesBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindLanguageVersion::class => [
                        'class' => \Zrcms\ContentLanguageDoctrine\Api\Repository\FindLanguageVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindLanguageVersionsBy::class => [
                        'class' => \Zrcms\ContentLanguageDoctrine\Api\Repository\FindLanguageVersionsBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    InsertLanguageVersion::class => [
                        'class' => \Zrcms\ContentLanguageDoctrine\Api\Repository\InsertLanguageVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
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
                            __DIR__ . '/Entity',
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
