<?php

namespace Zrcms\CoreDoctrine\Site\Api;

use Zrcms\Core\Site\Model\SitePublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UpdateSitePublished implements \Zrcms\Core\Site\Api\UpdateSitePublished
{
    /**
     * @param SitePublished $sitePublished
     * @param string        $modifiedByUserId
     * @param string        $modifiedReason
     * @param string|null   $host
     * @param string|null   $theme
     * @param array|null    $properties
     * @param array         $options
     *
     * @return SitePublished
     */
    public function __invoke(
        SitePublished $sitePublished,
        string $modifiedByUserId,
        string $modifiedReason,
        $host = null,
        $theme = null,
        $properties = null,
        array $options = []
    ): SitePublished
    {

    }
}
