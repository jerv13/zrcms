<?php

namespace Rcms\Core\Block\Api;

use Rcms\Core\Block\Model\Block;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindBlock
{
    /**
     * @param          $id
     * @param null|int $lockMode
     * @param null|int $lockVersion
     *
     * @return Block|null
     */
    public function __invoke(
        $id,
        $lockMode = null,
        $lockVersion = null,
        array $options = []
    );
}
