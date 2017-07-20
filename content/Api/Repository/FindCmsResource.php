<?php

namespace Zrcms\Content\Api\Repository;

use Zrcms\Content\Model\CmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindCmsResource
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return CmsResource|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
