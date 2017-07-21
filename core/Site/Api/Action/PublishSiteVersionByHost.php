<?php

namespace Zrcms\Core\Site\Api\Action;

use Zrcms\Core\Site\Model\SiteCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishSiteVersionByHost
{
    /**
     * @param string $siteHost
     * @param string $siteVersionId
     * @param string $publisherByUserId
     * @param string $publishReason
     * @param array  $options
     *
     * @return SiteCmsResource
     */
    public function __invoke(
        string $siteHost,
        string $siteVersionId,
        string $publisherByUserId,
        string $publishReason,
        array $options = []
    ): SiteCmsResource;
}
