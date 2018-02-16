<?php

namespace Zrcms\CoreAdminTools;

use Zrcms\CoreAdminTools\Api\GetApplicationStateAdminTools;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigZrcms
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            /**
             * ===== ZRCMS Application State =====
             */
            'zrcms-application-state' => [
                GetApplicationStateAdminTools::APPLICATION_STATE_KEY
                => GetApplicationStateAdminTools::class,
            ],

            'zrcms-components' => [
                'basic.zrcms-admin-tools'
                => 'json:' . __DIR__ . '/../zrcms-component.json',
            ],
        ];
    }
}
