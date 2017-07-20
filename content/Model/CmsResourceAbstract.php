<?php

namespace Zrcms\Content\Model;

use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class CmsResourceAbstract implements CmsResource
{
    use ImmutableTrait;
    use PropertiesTrait;

    protected $id = null;
    protected $contentRevisionId = null;
    protected $properties = [];

    /**
     * @param string $contentRevisionId
     * @param array  $properties
     */
    public function __construct(
        string $contentRevisionId,
        array $properties = []
    ) {
        // Enforce immutability
        if (!$this->isNew()) {
            return;
        }

        $this->id = Param::getAndRemove(
            $this->properties,
            CmsResourceProperties::ID
        );

        $this->contentRevisionId = $contentRevisionId;
        $this->properties = $properties;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getContentRevisionId(): string
    {
        return $this->contentRevisionId;
    }
}
