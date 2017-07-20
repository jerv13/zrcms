<?php

namespace Zrcms\Content\Model;

use Zrcms\Content\Exception\ImmutableException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Immutable
{
    /**
     * @return bool
     */
    public function isNew(): bool;

    /**
     * @return void
     * @throws ImmutableException
     */
    public function assertIsNew();
}
