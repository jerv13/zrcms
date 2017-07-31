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

    /**
     * @var string
     */
    protected $id = '';

    /**
     * @var string
     */
    protected $contentVersionId = '';

    /**
     * @var array
     */
    protected $properties = [];

    /**
     * Date object was first created
     *
     * @var \DateTime
     */
    protected $createdDate;

    /**
     * User ID of creator
     *
     * @var string
     */
    protected $createdByUserId;

    /**
     * Short description of create reason
     *
     * @var string
     */
    protected $createdReason;

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
        $this->new = false;

        $this->id = Param::get(
            $properties,
            PropertiesCmsResource::ID
        );

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
