<?php

namespace Zrcms\InputValidationZf2;

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
                    // @todo WIP
                ],
            ],
        ];
    }
}
