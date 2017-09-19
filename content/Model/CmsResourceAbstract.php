<?php

namespace Zrcms\Content\Model;

use Zrcms\Content\Exception\ContentVersionInvalid;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class CmsResourceAbstract
{
    use ImmutableTrait;
    use PropertiesTrait;
    use TrackableTrait;

    /**
     * @var null|string
     */
    protected $id = null;

    /**
     * @var bool
     */
    protected $published;

    /**
     * @var ContentVersion
     */
    protected $contentVersion;

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
     * @param string|null    $id
     * @param bool           $published
     * @param ContentVersion $contentVersion
     * @param array          $properties
     * @param string         $createdByUserId
     * @param string         $createdReason
     */
    public function __construct(
        $id,
        bool $published,
        ContentVersion $contentVersion,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        // Enforce immutability
        if (!$this->isNew()) {
            return;
        }
        $this->new = false;

        $this->id = $id;

        $this->published = $published;

        $this->contentVersion = $contentVersion;

        $this->assertValidContentVersion($contentVersion);

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
        return (string)$this->id;
    }

    /**
     * @return ContentVersion
     */
    public function getContentVersion()
    {
        return $this->contentVersion;
    }

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * @param $contentVersion
     *
     * @return void
     * @throws ContentVersionInvalid
     */
    protected function assertValidContentVersion($contentVersion)
    {
        if (!$contentVersion instanceof ContentVersion) {
            throw new ContentVersionInvalid(
                'ContentVersion must be instance of: ' . ContentVersion::class
                . ' got: ' . var_export($contentVersion, true)
                . ' for: ' . get_class($this)
            );
        }
    }
}
