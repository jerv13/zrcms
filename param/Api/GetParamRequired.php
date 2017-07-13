<?php

namespace Zrcms\Param\Api;

use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetParamRequired
{
    /**
     * @param array  $params
     * @param string $key
     *
     * @return mixed
     */
    public function __invoke(array $params, string $key)
    {
        return Param::getRequired($params, $key);
    }
}
