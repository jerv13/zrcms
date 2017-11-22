<?php

namespace Zrcms\ContentCore\Site\Api\Content;

use Zrcms\Content\Api\Content\FindContentVersion;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Site\Model\SiteVersion;

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
