<?php

namespace Zrcms\Content\Model;

use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContentAbstract implements Content
{
    use ImmutableTrait;
    use PropertiesTrait;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var array
     */
    protected $properties = null;

    /**
     * @param array $properties
     */
    public function __construct(
        array $properties
    ) {
        // Enforce immutability
        if (!$this->isNew()) {
            return;
        }


        $this->id = Param::getRequired(
            $properties,
            PropertiesContentVersion::ID
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
