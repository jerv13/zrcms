<?php

namespace Zrcms\ContentCore\Container\Api\CmsResourceHistory;

use Zrcms\ContentCore\Container\Model\ContainerCmsResourcePublishHistory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLastContainerCmsResourceHistory
{
    /**
     * @param string $cmsResourceId
     *
     * @return ContainerCmsResourcePublishHistory|null
     */
    public function __invoke(
        string $cmsResourceId
    );
}
