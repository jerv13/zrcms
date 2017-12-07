<?php

namespace Zrcms\CorePage\Api\CmsResource;

use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResource;
use Zrcms\CorePage\Model\PageCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindPageCmsResource extends FindContainerCmsResource
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return PageCmsResource|CmsResource|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
