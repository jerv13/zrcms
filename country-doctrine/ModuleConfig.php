<?php

namespace Zrcms\CountryDoctrine;

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
            'doctrine' => [
                'driver' => [
                    ModuleConfig::class => [
                        'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                        'cache' => 'array',
                        'paths' => [
                            __DIR__ . '/../Country/Entity',
                            __DIR__ . '/../Language/Entity',
                            __DIR__ . '/../Page/Entity',
                            __DIR__ . '/../Site/Entity',
                            __DIR__ . '/../Uid/Entity',
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
