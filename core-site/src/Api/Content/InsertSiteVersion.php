<?php

namespace Zrcms\CoreSite\Api\Content;

use Zrcms\Core\Api\Content\InsertContentVersion;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreSite\Model\SiteVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface InsertSiteVersion extends InsertContentVersion
{
    /**
     * @param SiteVersion|ContentVersion $siteVersion
     * @param array                      $options
     *
     * @return SiteVersion|ContentVersion
     */
    public function __invoke(
        ContentVersion $siteVersion,
        array $options = []
    ): ContentVersion;
}
