<?php

namespace Zrcms\Core\Container\Api\Repository;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindContainersByUris
{
    /**
     * @param array $uris
     * @param array $options
     *
     * @return array [Container]
     */
    public function __invoke(array $uris, array $options = []);
}
