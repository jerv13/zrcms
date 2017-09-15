<?php

namespace Zrcms\ContentDoctrine\Entity;

use Zrcms\Content\Model\Properties;
use Zrcms\Content\Model\Trackable;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CmsResourceEntity extends Entity, Properties, Trackable
{
    //    public function construct(
//        $id,
//        ContentVersion $contentVersion,
//        bool $published,
//        array $properties,
//        string $createdByUserId,
//        string $createdReason
//    );

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return ContentEntity
     */
    public function getContentVersion();

    /**
     * @return bool
     */
    public function isPublished(): bool;

    /**
     * Sync array of properties to object properties
     *
     * @param array $properties
     *
     * @return void
     */
    public function updateProperties(
        array $properties
    );
}
