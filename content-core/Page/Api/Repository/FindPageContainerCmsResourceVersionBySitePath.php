<?php

namespace Zrcms\ContentCore\Page\Api\Repository;

use Zrcms\Content\Exception\CmsResourceNotExistsException;
use Zrcms\Content\Exception\ContentVersionNotExistsException;
use Zrcms\Content\Model\CmsResourceVersion;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResourceVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindPageContainerCmsResourceVersionBySitePath
{
    /**
     * @param string $siteCmsResourceId
     * @param string $pageContainerCmsResourcePath
     * @param array  $options
     *
     * @return PageContainerCmsResourceVersion|CmsResourceVersion|null
     * @throws CmsResourceNotExistsException
     * @throws ContentVersionNotExistsException
     */
    public function __invoke(
        string $siteCmsResourceId,
        string $pageContainerCmsResourcePath,
        array $options = []
    );
}
