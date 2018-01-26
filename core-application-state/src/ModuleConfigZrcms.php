<?php

namespace Zrcms\CoreApplicationState;

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
                /* '{key}' => '{GetApplicationStateServiceName}' */
            ],
        ];
    }
}
