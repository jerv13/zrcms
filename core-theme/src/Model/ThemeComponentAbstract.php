<?php

namespace Zrcms\CoreTheme\Model;

use Zrcms\Core\Model\ComponentAbstract;
use Zrcms\CoreTheme\Exception\DefaultLayoutMissing;
use Zrcms\CoreTheme\Fields\FieldsThemeComponent;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ThemeComponentAbstract extends ComponentAbstract
{
    /**
     * @param string      $type
     * @param string      $name
     * @param string      $configUri
     * @param string      $moduleDirectory
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param null|string $createdDate
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
            FieldsThemeComponent::LAYOUT_VARIATIONS,
            get_class($this)
        );

        $layoutVariations = Property::getArray(
            $properties,
            FieldsThemeComponent::LAYOUT_VARIATIONS,
            []
        );

        // avoid setting them twice
        Property::remove($properties, FieldsThemeComponent::LAYOUT_VARIATIONS);

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

        // Must be dome after parent construct
        $this->addLayoutVariations($layoutVariations);

        if (!Property::has($this->getLayoutVariations(), $this->getPrimaryLayoutName())) {
            throw new DefaultLayoutMissing(
                'Primary layout (' . $this->getPrimaryLayoutName() . ') '
                . 'is missing for theme ' . $this->getName()
            );
        }
    }

    /**
     * @return mixed
     */
    public function getPrimaryLayoutName()
    {
        return $this->findProperty(
            FieldsThemeComponent::PRIMARY_LAYOUT_NAME,
            LayoutComponent::PRIMARY_NAME
        );
    }

    /**
     * @return LayoutComponent
     * @throws DefaultLayoutMissing
     */
    public function getPrimaryLayout()
    {
        return $this->getLayoutVariation(
            $this->getPrimaryLayoutName()
        );
    }

    /**
     * List of Layouts
     *
     * @return array
     */
    public function getLayoutVariations(): array
    {
        return $this->findProperty(
            FieldsThemeComponent::LAYOUT_VARIATIONS,
            []
        );
    }

    /**
     * @param string               $name
     * @param LayoutComponent|null $default
     *
     * @return LayoutComponent|null
     */
    public function getLayoutVariation(
        string $name,
        LayoutComponent $default = null
    ) {
        $layoutVariations = $this->getLayoutVariations();

        return Property::get(
            $layoutVariations,
            $name,
            $default
        );
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasLayoutVariation(
        string $name
    ): bool {
        $layoutVariations = $this->getLayoutVariations();

        return Property::has(
            $layoutVariations,
            $name
        );
    }

    /**
     * @param array $layoutComponents
     *
     * @return void
     */
    protected function addLayoutVariations(array $layoutComponents)
    {
        /** @var LayoutComponent $layoutComponent */
        foreach ($layoutComponents as $layoutComponent) {
            $this->addLayoutVariation($layoutComponent);
        }
    }

    /**
     * @param LayoutComponent $layoutComponent
     *
     * @return void
     */
    protected function addLayoutVariation(LayoutComponent $layoutComponent)
    {
        $layoutVariations = Property::getArray(
            $this->properties,
            FieldsThemeComponent::LAYOUT_VARIATIONS,
            []
        );

        $layoutVariations = Property::set(
            $layoutVariations,
            $layoutComponent->getName(),
            $layoutComponent
        );

        $this->properties = Property::set(
            $this->properties,
            FieldsThemeComponent::LAYOUT_VARIATIONS,
            $layoutVariations
        );
    }
}
