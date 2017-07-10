<?php

namespace Zrcms\Core;

/**
 * @deprecated Only a place holder
 *
 * @author James Jervis - https://github.com/jerv13
 */
class ApiNoop
{
    /**
     * @throws \Exception
     */
    public function __construct()
    {
        throw new \Exception('Api service must have implementation injected.');
    }
}
