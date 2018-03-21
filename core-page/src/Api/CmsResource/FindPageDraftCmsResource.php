<?php

namespace Zrcms\CorePage\Api\CmsResource;

use Zrcms\Core\Api\CmsResource\FindCmsResource;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CorePage\Model\PageDraftCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindPageDraftCmsResource extends FindCmsResource
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return PageDraftCmsResource|CmsResource|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
