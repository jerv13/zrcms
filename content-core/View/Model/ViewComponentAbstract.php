<?php

namespace Zrcms\ContentCore\View\Model;

use Zrcms\Content\Model\ComponentAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ViewComponentAbstract extends ComponentAbstract implements ViewComponent
{
    /**
     * @var array
     */
    protected $viewRenderDataGetters = [];

    /**
     * @var bool
     */
    protected $cacheable = false;

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
        $this->viewRenderDataGetters = Param::get(
            $properties,
            PropertiesViewComponent::LAYOUT_RENDER_DATA_GETTERS,
            []
        );

        parent::__construct(
            $properties = [],
            $createdByUserId,
            $createdReason
        );
    }
}
