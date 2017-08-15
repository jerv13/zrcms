<?php

namespace Zrcms\Acl;

use Zrcms\Acl\Api\IsAllowed;
use Zrcms\Acl\Api\IsAllowedAny;

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
                    IsAllowed::class => [
                        'class' => IsAllowedAny::class,
                        'arguments' => [],
                    ],
                ],
            ],
        ];
    }
}
