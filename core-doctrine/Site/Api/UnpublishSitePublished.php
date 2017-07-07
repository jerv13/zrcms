<?php

namespace Zrcms\CoreDoctrine\Site\Api;

use Zrcms\Core\Site\Model\SitePublished;
use Zrcms\Core\Site\Model\SiteUnpublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UnpublishSitePublished implements \Zrcms\Core\Site\Api\UnpublishSitePublished
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
    ): SiteUnpublished
    {

    }
}
