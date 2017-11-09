<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CmsResourceHistory extends Immutable, Trackable
{
    /**
     * @param string|null $id
     * @param string      $action
     * @param CmsResource $cmsResource
     * @param string      $createdByUserId
     * @param string      $createdReason
     */
    public function __construct(
        $id,
        string $action,
        CmsResource $cmsResource,
        string $createdByUserId,
        string $createdReason
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
     * @return CmsResource
     */
    public function getCmsResource();

    /**
     * @return ContentVersion
     */
    public function getContentVersion();
}
