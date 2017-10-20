<?php

namespace Zrcms\ContentCore\View\Model;

use Zrcms\Content\Exception\PropertyMissing;
use Zrcms\Content\Model\ComponentAbstract;
use Zrcms\ContentCore\View\Fields\FieldsViewLayoutTagsComponent;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ViewLayoutTagsComponentAbstract extends ComponentAbstract
{
    /**
     * @param string $classification
     * @param string $name
     * @param string $configLocation
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        string $classification,
        string $name,
        string $configLocation,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        Param::assertHas(
            $properties,
            FieldsViewLayoutTagsComponent::RENDER_TAGS_GETTER,
            PropertyMissing::buildThrower(
                FieldsViewLayoutTagsComponent::RENDER_TAGS_GETTER,
                $properties,
                get_class($this)
            )
        );

        parent::__construct(
            $classification,
            $name,
            $configLocation,
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
            FieldsViewLayoutTagsComponent::RENDER_TAGS_GETTER,
            ''
        );
    }
}
