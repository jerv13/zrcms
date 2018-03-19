<?php

namespace Zrcms\Core\Model;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Zrcms\CoreApplication\Api\GetGuidV4;

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
     * @param string|null $createdDate
     *
     * @throws \Zrcms\Core\Exception\TrackingInvalid
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        // Enforce immutability
        if (!$this->isNew()) {
            return;
        }
        $this->new = false;

        if (empty($id)) {
            $id = GetGuidV4::invoke();
        }

        $this->id = $id;

        $this->setCreatedData(
            $createdByUserId,
            $createdReason,
            $createdDate
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
