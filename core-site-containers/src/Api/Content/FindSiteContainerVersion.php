<?php

namespace Zrcms\CoreSiteContainer\Api\Content;

use Zrcms\Core\Api\Content\FindContentVersion;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreSiteContainer\Model\SiteContainerVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindSiteContainerVersion extends FindContentVersion
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return SiteContainerVersion|ContentVersion|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
