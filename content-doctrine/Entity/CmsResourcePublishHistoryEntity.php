<?php

namespace Zrcms\ContentDoctrine\Entity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CmsResourcePublishHistoryEntity
{
    /**
     * @param string|null       $id
     * @param string            $action
     * @param CmsResourceEntity $cmsResource
     * @param string            $publishedByUserId
     * @param string            $publishReason
     */
    public function __construct(
        $id,
        string $action,
        CmsResourceEntity $cmsResource,
        string $publishedByUserId,
        string $publishReason
    );

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getAction(): string;

    /**
     * @return CmsResourceEntity
     */
    public function getCmsResource();

    /**
     * @return array
     */
    public function getCmsResourceProperties(): array;

    /**
     * @return ContentEntity
     */
    public function getContentVersion();
}
