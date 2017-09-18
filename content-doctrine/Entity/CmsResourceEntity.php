<?php

namespace Zrcms\ContentDoctrine\Entity;

use Zrcms\Content\Model\Properties;
use Zrcms\Content\Model\Trackable;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CmsResourceEntity extends Entity, Properties, Trackable
{
    /**
     * @param int|null      $id
     * @param ContentEntity $contentEntity
     * @param bool          $published
     * @param array         $properties
     * @param string        $createdByUserId
     * @param string        $createdReason
     *
     * @return mixed
     */
    public function __construct(
        $id,
        ContentEntity $contentEntity,
        bool $published,
        array $properties,
        string $createdByUserId,
        string $createdReason
    );

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return ContentEntity
     */
    public function getContentEntity();

    /**
     * @return bool
     */
    public function isPublished(): bool;

    /**
     * Sync array of properties to object properties and set properties
     *
     * @param array $properties
     *
     * @return void
     */
    public function setProperties(
        array $properties
    );
}
