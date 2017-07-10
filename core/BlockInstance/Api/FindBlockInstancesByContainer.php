<?php

namespace Zrcms\Core\BlockInstance\Api;

use Zrcms\Core\Container\Model\Container;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindBlockInstancesByContainer
{
    /**
     * @param Container $container
     * @param array     $options
     *
     * @return mixed
     */
    public function __invoke(Container $container, array $options = []);
}
