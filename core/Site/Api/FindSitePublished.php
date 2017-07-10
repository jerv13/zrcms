<?php

namespace Zrcms\Core\Site\Api;

use Zrcms\Core\Site\Model\SitePublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindSitePublished
{
    /**
     * @param string $host
     * @param array  $options
     *
     * @return SitePublished|null
     */
    public function __invoke(
        string $host,
        array $options = []
    );
}
