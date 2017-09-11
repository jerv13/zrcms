<?php

namespace Zrcms\Content\Model;

use Zrcms\Content\Exception\ContentVersionNotExistsException;
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

        $contentVersion = Param::get(
            $properties,
            PropertiesCmsResource::CONTENT_VERSION,
            null
        );

        $this->assertValidContentVersion($contentVersion);

        $properties[PropertiesCmsResource::PUBLISHED] = Param::getBool(
            $properties,
            PropertiesCmsResource::PUBLISHED,
            true
        );

        $this->properties = $properties;

        $this->setCreatedData(
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getProperty(
            PropertiesCmsResource::ID,
            ''
        );
    }

    /**
     * @return ContentVersion
     */
    public function getContentVersion(): ContentVersion
    {
        return $this->getProperty(
            PropertiesCmsResource::CONTENT_VERSION,
            null
        );
    }

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->getProperty(
            PropertiesCmsResource::PUBLISHED,
            true
        );
    }

    /**
     * @param $contentVersion
     *
     * @return void
     * @throws ContentVersionNotExistsException
     */
    protected function assertValidContentVersion($contentVersion)
    {
        if (!$contentVersion instanceof ContentVersion) {
            throw new ContentVersionNotExistsException(
                'Missing required: ' . PropertiesCmsResource::CONTENT_VERSION
            );
        }
    }
}
