<?php

namespace Zrcms\File;

use Zrcms\Acl\Api\IsAllowedNone;
use Zrcms\File\Api\ReadFile;
use Zrcms\File\Api\ReadFileServiceAliasScheme;
use Zrcms\File\Api\ReadFileDefault;
use Zrcms\File\Api\ReadFileIfIsAllowed;
use Zrcms\File\Model\ServiceAliasFile;

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
                    ReadFile::class => [
                        'class' => ReadFileServiceAliasScheme::class,
                    ],
                    ReadFileDefault::class => [],
                    ReadFileIfIsAllowed::class => [
                        'arguments' => [
                            IsAllowedNone::class, // Over-ride me
                            ['literal' => []],
                        ]
                    ],
                ],
            ],

            'zrcms-service-alias' => [
                ServiceAliasFile::ZRCMS_FILE_READER => [
                    ReadFileDefault::SERVICE_ALIAS => ReadFileDefault::class,
                ],
            ],
        ];
    }
}
