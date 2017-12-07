<?php

namespace Zrcms\CorePage\Api\Content;

use Zrcms\Core\Api\Content\FindContentVersion;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CorePage\Model\PageVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindPageVersion extends FindContentVersion
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return PageVersion|ContentVersion|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
