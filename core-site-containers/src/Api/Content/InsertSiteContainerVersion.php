<?php

namespace Zrcms\CoreSiteContainer\Api\Content;

use Zrcms\Core\Api\Content\InsertContentVersion;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreSiteContainer\Model\SiteContainerVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface InsertSiteContainerVersion extends InsertContentVersion
{
    /**
     * @param SiteContainerVersion|ContentVersion $containerVersion
     * @param array                               $options
     *
     * @return SiteContainerVersion|ContentVersion
     */
    public function __invoke(
        ContentVersion $containerVersion,
        array $options = []
    ): ContentVersion;
}
