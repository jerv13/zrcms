<?php

namespace Zrcms\ViewHead\Model;

use Zrcms\CoreView\Model\ViewLayoutTagsComponentAbstract;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HeadSectionComponentBasic extends ViewLayoutTagsComponentAbstract implements HeadSectionComponent
{
    /**
     * @param string      $type
     * @param string      $name
     * @param string      $configUri
     * @param string      $moduleDirectory
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     *
     * @throws \Exception
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyMissing
     */
    public function __construct(
        string $type,
        string $name,
        string $configUri,
        string $moduleDirectory,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        Property::assertHas(
            $properties,
            PropertiesHeadSectionComponent::TAG
        );

        $properties[PropertiesHeadSectionComponent::SECTIONS] = Property::getArray(
            $properties,
            PropertiesHeadSectionComponent::SECTIONS,
            []
        );

        parent::__construct(
            $type,
            $name,
            $configUri,
            $moduleDirectory,
            $properties,
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->findProperty(
            PropertiesHeadSectionComponent::TAG
        );
    }

    /**
     * @param string $sectionName
     * @param string $entryName
     * @param array  $value
     *
     * @return array
     * @throws \Exception
     */
    public function addSectionEntry(
        string $sectionName,
        string $entryName,
        array $value
    ): array {
        $sections = $this->getSections();

        if (!array_key_exists($sectionName, $sections)) {
            throw new \Exception('Section does not exist: ' . $sectionName);
        }

        $sections[$sectionName][$entryName] = $value;

        $this->properties[PropertiesHeadSectionComponent::SECTIONS] = $sections;

        return $this->properties[PropertiesHeadSectionComponent::SECTIONS];
    }

    /**
     * @return array
     */
    public function getSections(): array
    {
        return $this->findProperty(
            PropertiesHeadSectionComponent::SECTIONS,
            []
        );
    }

    /**
     * @param string $sectionName
     * @param string $entryName
     *
     * @return array|null
     */
    public function findSectionEntry(
        string $sectionName,
        string $entryName
    ) {
        $sections = $this->getSections();

        if (!array_key_exists($sectionName, $sections)) {
            return null;
        }

        if (!array_key_exists($entryName, $sections[$sectionName])) {
            return null;
        }

        return $sections[$sectionName][$entryName];
    }
}
