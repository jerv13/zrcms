<?php

namespace Zrcms\Core\Site\Api\Repository;

use Zrcms\Content\Api\Repository\FindContentRevision;
use Zrcms\Content\Model\ContentRevision;
use Zrcms\Core\Site\Model\SiteRevision;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindSiteRevision extends FindContentRevision
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return SiteRevision|ContentRevision|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
