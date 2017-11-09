<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CmsResource extends TrackableModify
{
    /**
     * @param string|null    $id
     * @param bool           $published
     * @param ContentVersion $contentVersion
     * @param string         $createdByUserId
     * @param string         $createdReason
     * @param string|null    $createdDate
     */
    public function __construct(
        $id,
        bool $published,
        ContentVersion $contentVersion,
        string $createdByUserId,
        string $createdReason,
        string $createdDate = null
    );

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return bool
     */
    public function isPublished(): bool;

    /**
     * @param bool   $published
     * @param string $modifiedByUserId
     * @param string $modifiedReason
     * @param string $modifiedDate
     *
     * @return void
     */
    public function setPublished(
        bool $published,
        string $modifiedByUserId,
        string $modifiedReason,
        string $modifiedDate
    );

    /**
     * @return ContentVersion
     */
    public function getContentVersionId();

    /**
     * @return ContentVersion
     */
    public function getContentVersion();

    /**
     * @param ContentVersion $contentVersion
     * @param string         $modifiedByUserId
     * @param string         $modifiedReason
     * @param string         $modifiedDate
     *
     * @return void
     */
    public function setContentVersion(
        ContentVersion $contentVersion,
        string $modifiedByUserId,
        string $modifiedReason,
        string $modifiedDate
    );
}
