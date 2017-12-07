<?php

namespace Zrcms\Core\Model;

use Zrcms\CoreApplication\Api\GetGuidV4;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContentAbstract
{
    use ImmutableTrait;
    use PropertiesTrait;

    protected $id = null;

    /**
     * @var array
     */
    protected $properties = [];

    /**
     * @param array $properties
     * @param string|null  $id
     */
    public function __construct(
        array $properties,
        $id = null
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
