<?php

namespace Zrcms\Core\Api\Content;

use Zrcms\Core\Model\ContentVersion;

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
