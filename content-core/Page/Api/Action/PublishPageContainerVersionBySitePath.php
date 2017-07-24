<?php

namespace Zrcms\ContentCore\Page\Api\Action;

use Zrcms\ContentCore\Container\Api\ACtion\PublishContainerVersionBySitePath;
use Zrcms\ContentCore\Container\Model\ContainerCmsResource;

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
