<?php

namespace Rcms\Core\Validator\Api;

use Rcms\Core\Validator\Model\ValidatorResult;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Validate
{
    /**
     * @param string $value
     * @param array  $options
     *
     * @return ValidatorResult
     */
    public function __invoke(string $value, $options = []);
}
