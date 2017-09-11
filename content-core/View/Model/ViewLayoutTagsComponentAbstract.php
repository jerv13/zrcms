<?php

namespace Zrcms\ContentCore\View\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Content\Model\ComponentAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ViewLayoutTagsComponentAbstract extends ComponentAbstract
{
    /**
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        array $properties = [],
        string $createdByUserId,
        string $createdReason
    ) {
        Param::assertHas(
            $properties,
            PropertiesViewLayoutTagsComponent::RENDER_TAGS_GETTER,
            PropertyMissingException::build(
                PropertiesViewLayoutTagsComponent::RENDER_TAGS_GETTER,
                $properties,
                get_class($this)
            )
        );

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return string
     */
    public function getViewLayoutTagsGetter(): string
    {
        return Param::getString(
            $this->properties,
            PropertiesViewLayoutTagsComponent::RENDER_TAGS_GETTER,
            ''
        );
    }
}
