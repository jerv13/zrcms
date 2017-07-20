<?php

namespace Zrcms\Core\Site\Api\Repository;

use Zrcms\Content\Api\Repository\FindContentVersion;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\Core\Site\Model\SiteVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindSiteVersion extends FindContentVersion
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return SiteVersion|ContentVersion|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
