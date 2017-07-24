<?php

namespace Zrcms\CoreDoctrine\Site\Api;

use Zrcms\ContentCore\Site\Model\SitePublished;
use Zrcms\ContentCore\Site\Model\SiteUnpublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PublishSiteUnpublished implements \Zrcms\ContentCore\Site\Api\PublishSiteUnpublished
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
