<?php

namespace Zrcms\ContentLanguage;

use Zrcms\ContentCore\ApiNoop;
use Zrcms\ContentLanguage\Api\Action\PublishLanguageCmsResource;
use Zrcms\ContentLanguage\Api\Action\UnpublishLanguageCmsResource;
use Zrcms\ContentLanguage\Api\Repository\FindLanguageCmsResource;
use Zrcms\ContentLanguage\Api\Repository\FindLanguageCmsResourceByIso3;
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
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => PublishLanguageCmsResource::class],
                        ],
                    ],
                    UnpublishLanguageCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => UnpublishLanguageCmsResource::class],
                        ],
                    ],
                    FindLanguageCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindLanguageCmsResource::class],
                        ],
                    ],
                    FindLanguageCmsResourceByIso3::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindLanguageCmsResourceByIso3::class],
                        ],
                    ],
                    FindLanguageCmsResourcesBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindLanguageCmsResourcesBy::class],
                        ],
                    ],
                    FindLanguageVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindLanguageVersion::class],
                        ],
                    ],
                    FindLanguageVersionsBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => UnpublishLanguageCmsResource::class],
                        ],
                    ],
                    InsertLanguageVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => UnpublishLanguageCmsResource::class],
                        ],
                    ],
                ],
            ],
        ];
    }
}
