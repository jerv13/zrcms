<?php

namespace Zrcms\HttpApplicationState;

use Zrcms\HttpApplicationState\Acl\HttpApiIsAllowedApplicationState;
use Zrcms\HttpApplicationState\Acl\HttpApiIsAllowedApplicationStateFactory;
use Zrcms\HttpApplicationState\Middleware\HttpApplicationState;
use Zrcms\HttpApplicationState\Middleware\HttpApplicationStateByRequest;
use Zrcms\HttpApplicationState\Middleware\HttpApplicationStateByRequestFactory;
use Zrcms\HttpApplicationState\Middleware\HttpApplicationStateFactory;

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
                    HttpApiIsAllowedApplicationState::class => [
                        'factory' => HttpApiIsAllowedApplicationStateFactory::class,
                    ],
                    HttpApplicationState::class => [
                        'factory' => HttpApplicationStateFactory::class,
                    ],
                    HttpApplicationStateByRequest::class => [
                        'factory' => HttpApplicationStateByRequestFactory::class,
                    ],
                ],
            ],
        ];
    }
}
