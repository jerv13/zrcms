<?php

namespace Zrcms\Core\Page\Api\Action;

use Zrcms\Core\Container\Api\ACtion\PublishContainerVersionBySitePath;
use Zrcms\Core\Container\Model\ContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishPageContainerVersionBySitePath extends PublishContainerVersionBySitePath
{
    /**
     * @param string $siteCmsResourceId
     * @param string $pageContainerCmsResourcePath
     * @param string $pageContainerVersionId
     * @param string $publisherByUserId
     * @param string $publishReason
     * @param array  $options
     *
     * @return ContainerCmsResource
     */
    public function __invoke(
        string $siteCmsResourceId,
        string $pageContainerCmsResourcePath,
        string $pageContainerVersionId,
        string $publisherByUserId,
        string $publishReason,
        array $options = []
    ): ContainerCmsResource;
}
