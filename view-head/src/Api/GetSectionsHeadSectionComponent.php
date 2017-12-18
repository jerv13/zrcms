<?php

namespace Zrcms\ViewHead\Api;

use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\ViewHead\Model\HeadSectionComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetSectionsHeadSectionComponent implements GetSections
{
    protected $findComponent;

    /**
     * @param FindComponent $findComponent
     */
    public function __construct(
        FindComponent $findComponent
    ) {
        $this->findComponent = $findComponent;
    }

    /**
     * @param string $tagType
     * @param array  $options
     *
     * @return array
     */
    public function __invoke(
        string $tagType,
        array  $options = []
    ):array {
        /** @var HeadSectionComponent $component */
        $component = $this->findComponent->__invoke(
            'view-layout-tag',
            $tagType
        );

        return $component->getSections();
    }
}
