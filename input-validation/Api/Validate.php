<?php

namespace Zrcms\InputValidation\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Validate
{
    /**
     * @param array $data
     * @param array $options
     *
     * @return array messages
     */
    public function __invoke(
        array $data,
        array $options = []
    ): array;
}
