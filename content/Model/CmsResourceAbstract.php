<?php

namespace Zrcms\Content\Model;

use Zrcms\Content\Exception\ContentVersionInvalid;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class CmsResourceAbstract
{
    use TrackableModifyTrait;

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
     * Date object was first created
     *
     * @var \DateTime
     */
    protected $createdDate;

    /**
     * @param string|null    $id
     * @param bool           $published
     * @param ContentVersion $contentVersion
     * @param string         $createdByUserId
     * @param string         $createdReason
     * @param string|null    $createdDate
     */
    public function __construct(
        $id,
        bool $published,
        ContentVersion $contentVersion,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        $this->id = $id;

        $this->setContentVersion(
            $contentVersion,
            $createdByUserId,
            $createdReason,
            $createdDate
        );

        $this->setPublished(
            $published,
            $createdByUserId,
            $createdReason,
            $createdDate
        );

        $this->setCreatedData(
            $createdByUserId,
            $createdReason,
            $createdDate
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
     * @param bool        $published
     * @param string      $modifiedByUserId
     * @param string      $modifiedReason
     * @param string|null $modifiedDate
     *
     * @return void
     */
    public function setPublished(
        bool $published,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    ) {
        $this->setModifiedData(
            $modifiedByUserId,
            $modifiedReason,
            $modifiedDate
        );

        $this->published = $published;
    }

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * @return string
     */
    public function getContentVersionId(): string
    {
        if (!empty($this->contentVersion)) {
            return $this->contentVersion->getId();
        }

        return '';
    }

    /**
     * @return ContentVersion
     */
    public function getContentVersion()
    {
        return $this->contentVersion;
    }

    /**
     * @param ContentVersion $contentVersion
     * @param string         $modifiedByUserId
     * @param string         $modifiedReason
     * @param string         $modifiedDate
     *
     * @return void
     */
    public function setContentVersion(
        ContentVersion $contentVersion,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    ) {
        $this->assertValidContentVersion($contentVersion);

        $this->setModifiedData(
            $modifiedByUserId,
            $modifiedReason,
            $modifiedDate
        );

        $this->contentVersion = $contentVersion;
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
