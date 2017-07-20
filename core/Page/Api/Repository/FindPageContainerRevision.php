<?php

namespace Zrcms\Core\Page\Api\Repository;

use Zrcms\Content\Api\Repository\FindContentRevision;
use Zrcms\Content\Model\ContentRevision;
use Zrcms\Core\Page\Model\PageContainerRevision;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindPageContainerRevision extends FindContentRevision
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return PageContainerRevision|ContentRevision|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
