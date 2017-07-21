<?php

namespace Zrcms\Core\Container\Api\Repository;

use Zrcms\Core\Container\Model\ContainerCmsResource;
use Zrcms\Core\Site\Model\SiteCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishContainerVersionBySitePath
{
    /**
     * @param string $host
     * @param string $siteVersionId
     * @param string $publisherByUserId
     * @param string $publishReason
     * @param array  $options
     *
     * @return SiteCmsResource
     */
    public function __invoke(
        string $host,
        string $siteVersionId,
        string $publisherByUserId,
        string $publishReason,
        array $options = []
    ): SiteCmsResource;
}
