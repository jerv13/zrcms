<?php

namespace Zrcms\Content\Api\Repository;

use Zrcms\Content\Exception\CmsResourceNotExistsException;
use Zrcms\Content\Exception\ContentVersionNotExistsException;
use Zrcms\Content\Model\CmsResourceVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindCmsResourceVersion
{
    /**
     * @param string $cmsResourceId
     * @param array  $options
     *
     * @return CmsResourceVersion|null
     * @throws CmsResourceNotExistsException
     * @throws ContentVersionNotExistsException
     */
    public function __invoke(
        string $cmsResourceId,
        array $options = []
    );
}
