<?php

namespace Zrcms\InputValidationMessages;

use Zrcms\InputValidationMessages\Test\TestBasicImplementation;

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
        TestBasicImplementation::test();
        die;

        return [
            'dependencies' => [
                'config_factories' => [
                ],
            ],
        ];
    }
}
