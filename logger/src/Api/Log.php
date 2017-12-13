<?php

namespace Zrcms\Logger\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Log
{
    /**
     * @param string $level
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function __invoke(
        string $level,
        string $message,
        array $context = []
    );
}
