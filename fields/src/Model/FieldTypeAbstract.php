<?php

namespace Zrcms\Fields\Model;

use Zrcms\Core\Model\PropertiesTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldTypeAbstract implements FieldType
{
    use PropertiesTrait;

    protected $type;
    protected $properties;

    /**
     * @param string $type
     * @param array  $properties
     */
    public function __construct(
        string $type,
        array $properties
    ) {
        $this->type = $type;
        $this->properties = $properties;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
