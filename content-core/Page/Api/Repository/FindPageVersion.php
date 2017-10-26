<?php

namespace Zrcms\ContentCore\Page\Api\Repository;

use Zrcms\Content\Api\Repository\FindContentVersion;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Page\Model\PageVersion;

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
