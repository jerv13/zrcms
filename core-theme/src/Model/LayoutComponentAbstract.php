<?php

namespace Zrcms\CoreTheme\Model;

use Zrcms\Core\Exception\PropertyMissing;
use Zrcms\Core\Model\ComponentAbstract;
use Zrcms\CoreTheme\Fields\FieldsLayoutComponent;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class LayoutComponentAbstract extends ComponentAbstract
{
    /**
     * @param string $type
     * @param string $name
     * @param string $configUri
     * @param string $moduleDirectory
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     * @param null   $createdDate
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
            FieldsLayoutComponent::THEME_NAME,
            get_class($this)
        );

        Property::assertHas(
            $properties,
            FieldsLayoutComponent::HTML,
            get_class($this)
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
    public function getThemeName(): string
    {
        return $this->findProperty(
            FieldsLayoutComponent::THEME_NAME,
            ''
        );
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->findProperty(
            FieldsLayoutComponent::HTML,
            ''
        );
    }
}
