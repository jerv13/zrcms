<?php

namespace Zrcms\ContentDoctrine\Entity;

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
     * @return CmsResourceEntity
     */
    public function getCmsResource();

    /**
     * @return ContentEntity
     */
    public function getContentVersion();
}
