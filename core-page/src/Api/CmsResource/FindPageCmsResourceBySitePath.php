<?php

namespace Zrcms\CorePage\Api\CmsResource;

use Zrcms\CorePage\Model\PageCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindPageCmsResourceBySitePath
{
    /**
     * @param string $siteCmsResourceId
     * @param string $pageCmsResourcePath
     * @param bool   $published
     * @param array  $options
     *
     * @return PageCmsResource|null
     */
    public function __invoke(
        string $siteCmsResourceId,
        string $pageCmsResourcePath,
        bool $published = true,
        array $options = []
    );
}
