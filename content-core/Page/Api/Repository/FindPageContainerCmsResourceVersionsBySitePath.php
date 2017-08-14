<?php

namespace Zrcms\ContentCore\Page\Api\Repository;

use Zrcms\Content\Model\CmsResourceVersion;
use Zrcms\ContentCore\PageContainer\Model\PageContainerCmsResourceVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindPageContainerCmsResourceVersionsBySitePath
{
    /**
     * @param string $siteCmsResourceId
     * @param string $pageContainerCmsResourcePath
     * @param array  $options
     *
     * @return PageContainerCmsResourceVersion|CmsResourceVersion|null
     */
    public function __invoke(
        string $siteCmsResourceId,
        string $pageContainerCmsResourcePath,
        array $options = []
    );
}
