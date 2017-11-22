<?php

namespace Zrcms\HttpRedirect;

use Zrcms\ContentCore\Site\Api\GetSiteCmsResourceByRequest;

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
                    SiteExists::class => [
                        'arguments' => [
                            GetSiteCmsResourceByRequest::class,
                        ],
                    ],
                ],
            ],
        ];
    }
}
