<?php

namespace Zrcms\ContentCore\Container\Api\Action;

use Zrcms\ContentCore\Container\Model\ContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishContainerVersionBySitePath
{
    /**
     * @param string $siteCmsResourceId
     * @param string $containerCmsResourcePath
     * @param string $containerVersionId
     * @param string $publisherByUserId
     * @param string $publishReason
     * @param array  $options
     *
     * @return ContainerCmsResource
     */
    public function __invoke(
        string $siteCmsResourceId,
        string $containerCmsResourcePath,
        string $containerVersionId,
        string $publisherByUserId,
        string $publishReason,
        array $options = []
    ): ContainerCmsResource;
}
