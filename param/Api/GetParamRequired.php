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
     * @param null   $exception
     *
     * @return mixed
     */
    public function __invoke(array $params, string $key, $exception = null)
    {
        return Param::getRequired($params, $key, $exception);
    }
}
