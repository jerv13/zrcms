<?php

namespace Zrcms\HttpExpressive1\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetStatusSitePropertyPagePath
{
    /**
     * @param int|string $status
     * @param null       $default
     *
     * @return mixed|null
     */
    public function __invoke($status, $default = null);
}
