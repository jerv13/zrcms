<?php

namespace Zrcms\ContentCoreDoctrine\Site\Api;

use Zrcms\ContentCore\Site\Model\SitePublished;
use Zrcms\ContentCore\Site\Model\SiteUnpublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UnpublishSitePublished implements \Zrcms\ContentCore\Site\Api\UnpublishSitePublished
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
