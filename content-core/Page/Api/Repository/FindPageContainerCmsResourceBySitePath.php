<?php

namespace Zrcms\ContentCore\Page\Api\Repository;

use Zrcms\ContentCore\Page\Model\PageContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindPageContainerCmsResourceBySitePath
{
    /**
     * @param string $siteCmsResourceId
     * @param string $pageContainerCmsResourcePath
     * @param bool   $published
     * @param array  $options
     *
     * @return PageContainerCmsResource|null
     */
    public function __invoke(
        string $siteCmsResourceId,
        string $pageContainerCmsResourcePath,
        bool $published = true,
        array $options = []
    );
}
