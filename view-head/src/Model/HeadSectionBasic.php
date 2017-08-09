<?php

namespace Zrcms\ViewHead\Model;

use Zrcms\Content\Model\ContentAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HeadSectionBasic extends ContentAbstract implements HeadSection
{
    /**
     * @param array $properties
     */
    public function __construct(array $properties)
    {
        Param::assertHas(
            $properties,
            PropertiesHeadSection::TAG
        );

        $properties[PropertiesHeadSection::SECTIONS] = Param::getArray(
            $properties,
            PropertiesHeadSection::SECTIONS,
            []
        );

        parent::__construct($properties);
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->getProperty(
            PropertiesHeadSection::TAG
        );
    }

    /**
     * @return array
     */
    public function getSections(): array
    {
        return $this->getProperty(
            PropertiesHeadSection::SECTIONS,
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
