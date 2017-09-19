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
     * @param bool $published
     *
     * @return void
     */
    public function setPublished(bool $published);

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
