<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContentVersionAbstract
{
    use ImmutableTrait;
    use PropertiesTrait;
    use TrackableTrait;

    /**
     * ID
     *
     * @var string
     */
    protected $id;

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
     * @param string|null $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     */
    public function __construct(
        $id,
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

        $this->setCreatedData(
            $createdByUserId,
            $createdReason
        );

        $this->properties = $properties;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return (string)$this->id;
    }
}
