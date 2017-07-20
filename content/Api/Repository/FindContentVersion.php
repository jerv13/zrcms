<?php

namespace Zrcms\Content\Api\Repository;

use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindContentVersion
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return ContentVersion|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
