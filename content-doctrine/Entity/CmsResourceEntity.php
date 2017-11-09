<?php

namespace Zrcms\ContentDoctrine\Entity;

use Zrcms\Content\Model\TrackableModify;

/**
 * Mimic CmsResource
 *
 * @author James Jervis - https://github.com/jerv13
 */
interface CmsResourceEntity extends Entity, TrackableModify
{
    /**
     * @param bool          $published
     * @param ContentEntity $contentVersion
     * @param string        $modifiedByUserId
     * @param string        $modifiedReason
     * @param string|null   $modifiedDate
     *
     * @return void
     */
    public function update(
        bool $published,
        ContentEntity $contentVersion,
        string $modifiedByUserId,
        string $modifiedReason,
        string $modifiedDate = null
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
     * @return ContentEntity
     */
    public function getContentEntity();
}
