<?php

namespace Zrcms\Core\Site\Api;

use Zrcms\Core\Site\Model\SitePublished;
use Zrcms\Core\Site\Model\SiteUnpublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishSiteUnpublished
{
    /**
     * @param SiteUnpublished $siteUnpublished
     * @param array           $options
     *
     * @return SitePublished
     */
    public function __invoke(
        SiteUnpublished $siteUnpublished,
        array $options = []
    ): SitePublished;
}
