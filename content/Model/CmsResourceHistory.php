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
     * @param string      $publishedByUserId
     * @param string      $publishReason
     * @param string|null $publishDate
     */
    public function __construct(
        $id,
        string $action,
        CmsResource $cmsResource,
        string $publishedByUserId,
        string $publishReason,
        $publishDate = null
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
     * @return string
     */
    public function getCmsResourceId(): string;

    /**
     * @return CmsResource
     */
    public function getCmsResource();

    /**
     * @return string
     */
    public function getContentVersionId(): string;

    /**
     * @return ContentVersion
     */
    public function getContentVersion();
}
