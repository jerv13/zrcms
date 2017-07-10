<?php

namespace Zrcms\Core\Container\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindContainers
{
    /**
     * @param array $uris
     * @param array $options
     *
     * @return array [Container]
     */
    public function __invoke(array $uris, array $options = []);
}
