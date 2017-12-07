<?php

namespace Zrcms\CoreSite\Api\Content;

use Zrcms\Core\Api\Content\FindContentVersion;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreSite\Model\SiteVersion;

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
