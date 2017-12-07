<?php

namespace Zrcms\CoreApplicationDoctrine\Entity;

use Zrcms\Core\Model\TrackableModify;

/**
 * Mimic CmsResource
 *
 * @author James Jervis - https://github.com/jerv13
 */
interface CmsResourceEntity extends Entity, TrackableModify
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return bool
     */
    public function isPublished(): bool;

    /**
     * @param bool        $published
     * @param string      $modifiedByUserId
     * @param string      $modifiedReason
     * @param string|null $modifiedDate
     *
     * @return void
     */
    public function setPublished(
        bool $published,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    );

    /**
     * @return ContentEntity
     */
    public function getContentVersionId();

    /**
     * @return ContentEntity
     */
    public function getContentVersion();

    /**
     * @param ContentEntity $contentVersion
     * @param string        $modifiedByUserId
     * @param string        $modifiedReason
     * @param string|null   $modifiedDate
     *
     * @return void
     */
    public function setContentVersion(
        ContentEntity $contentVersion,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    );
}
