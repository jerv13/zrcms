<?php

namespace Zrcms\Core\Validator\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ValidatorResult
{
    /**
     * @return bool
     */
    public function isValid(): bool;

    /**
     * @return string
     */
    public function getMessage(): string;
}
