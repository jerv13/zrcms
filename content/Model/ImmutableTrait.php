<?php

namespace Zrcms\Content\Model;

use Zrcms\Content\Exception\ImmutableException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
trait ImmutableTrait
{
    /**
     * @return bool
     */
    public function isNew(): bool
    {
        return empty($this->id);
    }

    /**
     * @return void
     * @throws ImmutableException
     */
    public function assertIsNew()
    {
        if (!$this->isNew()) {
            throw new ImmutableException(
                'Data my not be changed'
            );
        }
    }
}
