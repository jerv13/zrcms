<?php

namespace Zrcms\CoreApplicationDoctrine\Entity;

use Zrcms\Core\Model\Trackable;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CmsResourceHistoryEntity extends Entity, Trackable
{
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
     * @return CmsResourceEntity
     */
    public function getCmsResource();

    /**
     * @return string
     */
    public function getContentVersionId(): string;

    /**
     * @return ContentEntity
     */
    public function getContentVersion();
}
