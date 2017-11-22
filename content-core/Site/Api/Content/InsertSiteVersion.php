<?php

namespace Zrcms\ContentCore\Site\Api\Content;

use Zrcms\Content\Api\Content\InsertContentVersion;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Site\Model\SiteVersion;

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
