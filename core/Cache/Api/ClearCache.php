<?php

namespace Zrcms\Core\Cache\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ClearCache
{
    /**
     * @return bool
     */
    public function __invoke(): bool;
}
