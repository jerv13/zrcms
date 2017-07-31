<?php

namespace Zrcms\Content\Model;

use Zrcms\Content\Exception\PropertyMissingException;
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
    protected $id = '';

    /**
     * @var array
     */
    protected $properties = [];

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
        $this->new = false;

        $this->id = Param::getRequired(
            $properties,
            PropertiesContentVersion::ID,
            new PropertyMissingException(
                'Required property (' . PropertiesContentVersion::ID. ') is missing in: '
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
}
