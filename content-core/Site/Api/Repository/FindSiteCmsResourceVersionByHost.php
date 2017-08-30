<?php

namespace Zrcms\ContentCore\Site\Api\Repository;

use Zrcms\Content\Exception\CmsResourceNotExistsException;
use Zrcms\Content\Exception\ContentVersionNotExistsException;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceVersion;

/**
 * Find published CmsResource by host
 *
 * @author James Jervis - https://github.com/jerv13
 */
interface FindSiteCmsResourceVersionByHost
{
    /**
     * @param string $host
     * @param array  $options
     *
     * @return SiteCmsResourceVersion|null
     * @throws CmsResourceNotExistsException
     * @throws ContentVersionNotExistsException
     */
    public function __invoke(
        string $host,
        array $options = []
    );
}
