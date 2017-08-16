<?php

namespace Zrcms\ViewHead\Model;

use Zrcms\ContentCore\View\Model\ViewLayoutTagsComponent;
use Zrcms\ContentCore\View\Model\ViewLayoutTagsComponentAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HeadSectionComponent extends ViewLayoutTagsComponentAbstract implements ViewLayoutTagsComponent
{
    /**
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        Param::assertHas(
            $properties,
            PropertiesHeadSectionComponent::TAG
        );

        $properties[PropertiesHeadSectionComponent::SECTIONS] = Param::getArray(
            $properties,
            PropertiesHeadSectionComponent::SECTIONS,
            []
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
    public function getTag(): string
    {
        return $this->getProperty(
            PropertiesHeadSectionComponent::TAG
        );
    }

    /**
     * @return array
     */
    public function getSections(): array
    {
        return $this->getProperty(
            PropertiesHeadSectionComponent::SECTIONS,
            []
        );
    }

    /**
     * @param string $name
     * @param null   $default
     *
     * @return array|null
     */
    public function getSection(string $name, $default = null)
    {
        $sections = $this->getSections();

        return Param::getArray(
            $sections,
            $name,
            []
        );
    }
}
