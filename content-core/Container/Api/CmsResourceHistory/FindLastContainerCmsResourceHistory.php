<?php

namespace Zrcms\ContentCore\Container\Api\CmsResourceHistory;

use Zrcms\ContentCore\Container\Model\ContainerCmsResourceHistory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLastContainerCmsResourceHistory
{
    /**
     * @param string $cmsResourceId
     *
     * @return ContainerCmsResourceHistory|null
     */
    public function __invoke(
        string $cmsResourceId
    );
}
