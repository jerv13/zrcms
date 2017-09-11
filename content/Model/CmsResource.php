<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CmsResource extends Immutable, Properties, Trackable
{
    /**
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        array $properties,
        string $createdByUserId,
        string $createdReason
    );

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return ContentVersion
     */
    public function getContentVersion(): ContentVersion;

    /**
     * @return bool
     */
    public function isPublished(): bool;
}
