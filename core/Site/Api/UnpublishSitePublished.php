<?php

namespace Zrcms\Core\Site\Api;

use Zrcms\Core\Site\Model\SitePublished;
use Zrcms\Core\Site\Model\SiteUnpublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UnpublishSitePublished
{
    /**
     * @param SitePublished $sitePublished
     * @param array         $options
     *
     * @return SiteUnpublished
     */
    public function __invoke(
        SitePublished $sitePublished,
        array $options = []
    ): SiteUnpublished;
}
