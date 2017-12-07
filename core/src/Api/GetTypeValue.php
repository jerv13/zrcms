<?php

namespace Zrcms\Core\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetTypeValue
{
    /**
     * @param string $type
     * @param string $key
     * @param null   $default
     *
     * @return string|mixed
     */
    public function __invoke(
        string $type,
        string $key,
        $default = null
    );
}
