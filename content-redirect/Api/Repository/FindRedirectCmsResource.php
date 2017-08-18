<?php

namespace Zrcms\ContentRedirect\Api\Repository;

use Zrcms\Content\Api\Repository\FindCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentRedirect\Model\RedirectCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindRedirectCmsResource extends FindCmsResource
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return RedirectCmsResource|CmsResource|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
