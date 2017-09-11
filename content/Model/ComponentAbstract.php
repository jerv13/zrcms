<?php

namespace Zrcms\Content\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ComponentAbstract
{
    use ImmutableTrait;
    use PropertiesTrait;
    use TrackableTrait;

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
        $this->new = false;

        Param::assertHas(
            $properties,
            PropertiesComponent::NAME,
            PropertyMissingException::build(
                PropertiesComponent::NAME,
                $properties,
                get_class($this)
            )
        );

        Param::assertHas(
            $properties,
            PropertiesComponent::CONFIG_LOCATION,
            PropertyMissingException::build(
                PropertiesComponent::CONFIG_LOCATION,
                $properties,
                get_class($this)
            )
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
    public function getName(): string
    {
        return $this->getProperty(
            PropertiesComponent::NAME,
            ''
        );
    }

    /**
     * @return string
     */
    public function getConfigLocation(): string
    {
        return $this->getProperty(
            PropertiesComponent::CONFIG_LOCATION,
            ''
        );
    }
}
