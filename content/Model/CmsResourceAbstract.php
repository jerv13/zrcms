<?php

namespace Zrcms\Content\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class CmsResourceAbstract implements CmsResource
{
    use ImmutableTrait;
    use PropertiesTrait;
    use TrackableTrait;

    protected $id = null;
    protected $contentVersionId = null;
    protected $properties = [];

    /**
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        // Enforce immutability
        if (!$this->isNew()) {
            return;
        }

        // @todo might use getAndRemove
        $this->id = Param::get(
            $properties,
            PropertiesCmsResource::ID
        );

        // @todo might use getAndRemoveRequired
        $this->contentVersionId = Param::getRequired(
            $properties,
            PropertiesCmsResource::CONTENT_VERSION_ID,
            new PropertyMissingException(
                'Required property (' . PropertiesCmsResource::CONTENT_VERSION_ID . ') is missing in: '
                . get_class($this)
            )
        );

        $this->properties = $properties;
    }

    /**
     * @return bool
     */
    public function isNew(): bool
    {
        return empty($this->id);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getContentVersionId(): string
    {
        return $this->contentVersionId;
    }
}
