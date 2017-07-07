<?php

namespace Zrcms\CoreDoctrine\Site\Api;

use Zrcms\Core\Site\Model\SitePublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CreateSitePublished implements \Zrcms\Core\Site\Api\CreateSitePublished
{
    /**
     * @param string $host
     * @param string $theme
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     * @param null   $id
     * @param array  $options
     *
     * @return SitePublished
     */
    public function __invoke(
        string $host,
        string $theme,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $id = null,
        array $options = []
    ): SitePublished
    {

    }
}
