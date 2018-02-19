<?php

namespace Zrcms\CoreView\Api;

use Zrcms\CorePage\Model\PageCmsResource;
use Zrcms\CoreView\Exception\PageNotFound;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetPageCmsResource
{
    /**
     * @param string    $siteCmsResourceId
     * @param string    $path
     * @param bool|null $published
     *
     * @return PageCmsResource
     * @throws PageNotFound
     */
    public function __invoke(
        string $siteCmsResourceId,
        string $path,
        $published = true
    ): PageCmsResource;
}
