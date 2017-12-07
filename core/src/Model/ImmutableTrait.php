<?php

namespace Zrcms\Core\Model;

use Zrcms\Core\Exception\ImmutableException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
trait ImmutableTrait
{
    /**
     * @var bool
     */
    protected $new = true;


    /**
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->new;
    }

    /**
     * @return void
     * @throws ImmutableException
     */
    public function assertIsNew()
    {
        if (!$this->isNew()) {
            throw new ImmutableException(
                'Data my not be changed in ' . get_class($this)
            );
        }
    }
}
