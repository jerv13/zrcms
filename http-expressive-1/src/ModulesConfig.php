<?php

namespace Zrcms\HttpExpressive1;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModulesConfig
{
    /**
     * __invoke
     *
     * @return array
     */
    public function __invoke()
    {
        return require(__DIR__ . '/../config/modules.php');
    }
}
