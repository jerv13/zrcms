<?php

namespace Zrcms\ContentCore\ViewRenderDataGetter\Model;

use Zrcms\Content\Model\ComponentAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ViewRenderDataGetterComponentAbstract
    extends ComponentAbstract
    implements ViewRenderDataGetterComponent
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
    public function getViewRenderDataGetter(): string
    {
        return Param::getString(
            $this->properties,
            PropertiesViewRenderDataGetterComponent::RENDER_DATA_GETTER,
            ''
        );
    }
}
