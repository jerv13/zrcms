<?php

namespace Zrcms\Core\Block\Api;

use Zrcms\Core\Block\Model\Block;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLayout
{
    /**
     * @param string   $name
     * @param null|int $lockMode
     * @param null|int $lockVersion
     * @param array $options
     *
     * @return Block|null
     */
    public function __invoke(
        $name,
        array $options = []
    );
}
