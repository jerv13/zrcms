<?php

namespace Zrcms\InputValidation\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ValidationResult
{
    /**
     * @return bool
     */
    public function isValid():bool;

    /**
     * @return string
     */
    public function getCode():string;

    /**
     * @return array
     */
    public function getDetails(): array;

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    public function findDetail(string $key, $default = null);
}
