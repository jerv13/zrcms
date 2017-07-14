<?php

namespace Zrcms\Content\Api\Repository;

use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UpsertContent
{
    /**
     * @param Content $cmsResource
     * @param array   $options
     *
     * @return Content
     */
    public function __invoke(
        Content $cmsResource,
        array $options = []
    ): Content;
}
