<?php

namespace Zrcms\CoreDoctrine\Site\Api;

use Zrcms\Core\Site\Model\SitePublished;
use Zrcms\Core\Site\Model\SiteUnpublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PublishSiteUnpublished implements \Zrcms\Core\Site\Api\PublishSiteUnpublished
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
    ): SitePublished
    {

    }
}
