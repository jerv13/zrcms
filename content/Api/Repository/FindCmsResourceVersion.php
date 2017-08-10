<?php

namespace Zrcms\Content\Api\Repository;

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
     */
    public function __invoke(
        string $cmsResourceId,
        array $options = []
    );
}
