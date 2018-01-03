<?php

namespace Zrcms\CoreView\Api;

use Zrcms\CoreSite\Model\SiteCmsResource;
use Zrcms\CoreView\Exception\SiteNotFound;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetSiteCmsResource
{
    /**
     * @param string $host
     *
     * @return SiteCmsResource
     * @throws SiteNotFound
     */
    public function __invoke(string $host): SiteCmsResource;
}
