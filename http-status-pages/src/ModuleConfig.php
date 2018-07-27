<?php

namespace Zrcms\HttpStatusPages;

use Zrcms\HttpStatusPages\Api\GetStatusPage;
use Zrcms\HttpStatusPages\Api\GetStatusPageBasicFactory;
use Zrcms\HttpStatusPages\Middleware\ResponseMutatorStatusPage;
use Zrcms\HttpStatusPages\Middleware\ResponseMutatorStatusPageFactory;

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
                    GetStatusPage::class => [
                        'factory' => GetStatusPageBasicFactory::class,
                    ],

                    ResponseMutatorStatusPage::class => [
                        'factory' => ResponseMutatorStatusPageFactory::class,
                    ],
                ],
            ],
        ];
    }
}
