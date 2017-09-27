<?php

namespace Zrcms\ContentCore\Site\Api\Repository;

use Zrcms\ContentCore\Site\Model\SiteCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindSiteCmsResourceByHost
{
    /**
     * @param string $host
     * @param bool   $published
     * @param array  $options
     *
     * @return SiteCmsResource|null
     */
    public function __invoke(
        string $host,
        bool $published = true,
        array $options = []
    );
}
