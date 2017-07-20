<?php

namespace Zrcms\Content\Api\Repository;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface DeleteCmsResource
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return bool success
     */
    public function __invoke(
        string $id,
        array $options = []
    ): bool;
}
