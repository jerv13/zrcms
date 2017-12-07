<?php

namespace Zrcms\CoreRedirect\Api\CmsResource;

use Zrcms\Core\Api\CmsResource\FindCmsResource;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreRedirect\Model\RedirectCmsResource;

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
