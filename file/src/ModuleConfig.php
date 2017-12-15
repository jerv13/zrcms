<?php

namespace Zrcms\File;

use Zrcms\Acl\Api\IsAllowedNone;
use Zrcms\File\Api\ReadFile;
use Zrcms\File\Api\ReadFileComposite;
use Zrcms\File\Api\ReadFileDefault;
use Zrcms\File\Api\ReadFileRestricted;
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
                        'class' => ReadFileComposite::class,
                    ],
                    ReadFileDefault::class => [],
                    ReadFileRestricted::class => [
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
