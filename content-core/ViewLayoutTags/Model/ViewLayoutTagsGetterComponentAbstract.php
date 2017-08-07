<?php

namespace Zrcms\ContentCore\ViewLayoutTags\Model;

use Zrcms\Content\Model\ComponentAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ViewLayoutTagsGetterComponentAbstract
    extends ComponentAbstract
    implements ViewLayoutTagsGetterComponent
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
        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return string
     */
    public function getViewRenderTagsGetter(): string
    {
        return Param::getString(
            $this->properties,
            PropertiesViewLayoutTagsGetterComponent::RENDER_TAGS_GETTER,
            ''
        );
    }
}
