<?php

namespace Zrcms\CoreContainer\Api\CmsResourceHistory;

use Zrcms\CoreContainer\Model\ContainerCmsResourceHistory;

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
