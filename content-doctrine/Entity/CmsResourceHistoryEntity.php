<?php

namespace Zrcms\ContentDoctrine\Entity;

use Zrcms\Content\Exception\ContentVersionExists;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CmsResourceHistoryEntity
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
