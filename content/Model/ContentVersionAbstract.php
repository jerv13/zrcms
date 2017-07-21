<?php

namespace Zrcms\Content\Model;

use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContentVersionAbstract implements ContentVersion
{
    use ImmutableTrait;
    use PropertiesTrait;
    use TrackableTrait;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var array
     */
    protected $properties = null;

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


        $this->id = Param::get(
            $properties,
            PropertiesContentVersion::ID
        );

        $this->setCreatedData(
            $createdByUserId,
            $createdReason
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
}
