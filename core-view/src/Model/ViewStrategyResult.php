<?php

namespace Zrcms\CoreView\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ViewStrategyResult
{
    const OK_STATUS = 200;

    /**
     * @return string|null
     */
    public function getStrategy();

    /**
     * Best to use HTTP Status codes
     *
     * @return int
     */
    public function getStatus(): int;

    /**
     * @return bool
     */
    public function isOk(): bool;
}
