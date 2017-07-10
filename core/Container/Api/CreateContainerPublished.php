<?php

namespace Zrcms\Core\Container\Api;

use Zrcms\Core\Container\Model\ContainerPublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CreateContainerPublished
{
    /**
     * @param string $uri
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $properties
     * @param array  $options
     *
     * @return ContainerPublished
     */
    public function __invoke(
        string $uri,
        string $createdByUserId,
        string $createdReason,
        array $properties,
        array $options = []
    ): ContainerPublished;
}
