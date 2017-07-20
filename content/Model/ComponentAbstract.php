<?php

namespace Zrcms\Content\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ComponentAbstract implements Component
{
    use ImmutableTrait;
    use PropertiesTrait;
    use TrackableTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $directory;

    /**
     * @var array
     */
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

        $this->name = Param::getAndRemoveRequired(
            $properties,
            PropertiesComponent::NAME,
            new PropertyMissingException(
                'Required property (' . PropertiesComponent::NAME . ') is missing'
            )
        );

        $this->directory = Param::getAndRemoveRequired(
            $properties,
            PropertiesComponent::DIRECTORY,
            new PropertyMissingException(
                'Required property (' . PropertiesComponent::DIRECTORY . ') is missing'
            )
        );

        $this->properties = $properties;

        $this->setCreatedData(
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return bool
     */
    public function isNew(): bool
    {
        return empty($this->name);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDirectory(): string
    {
        return $this->directory;
    }
}
