<?php

namespace Zrcms\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetParam
{
    /**
     * @param array  $params
     * @param string $key
     * @param null   $default
     *
     * @return mixed|null
     */
    public function __invoke(array $params, string $key, $default = null)
    {
        return Param::get($params, $key, $default);
    }
}
