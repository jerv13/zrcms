<?php

namespace Zrcms\Core\Site\Api\Repository;

use Zrcms\Core\Site\Model\SiteCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindSiteCmsResourcesByHost
{
    /**
     * @param string $host
     * @param array  $options
     *
     * @return SiteCmsResource|null
     */
    public function __invoke(
        string $host,
        array $options = []
    );
}
