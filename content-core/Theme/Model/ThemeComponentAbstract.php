<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Exception\PropertyMissing;
use Zrcms\Content\Model\ComponentAbstract;
use Zrcms\ContentCore\Theme\Exception\DefaultLayoutMissingException;
use Zrcms\ContentCore\Theme\Fields\FieldsThemeComponent;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ThemeComponentAbstract extends ComponentAbstract
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
            FieldsThemeComponent::LAYOUT_VARIATIONS,
            PropertyMissing::buildThrower(
                FieldsThemeComponent::LAYOUT_VARIATIONS,
                $properties,
                get_class($this)
            )
        );

        $layoutVariations = Param::getArray(
            $properties,
            FieldsThemeComponent::LAYOUT_VARIATIONS,
            []
        );

        // avoid setting them twice
        Param::remove($properties, FieldsThemeComponent::LAYOUT_VARIATIONS);

        parent::__construct(
            $classification,
            $name,
            $configLocation,
            $properties,
            $createdByUserId,
            $createdReason
        );

        // Must be dome after parent construct
        $this->addLayoutVariations($layoutVariations);

        Param::assertHas(
            $this->getLayoutVariations(),
            $this->getPrimaryLayoutName(),
            new DefaultLayoutMissingException(
                'Primary layout (' . $this->getPrimaryLayoutName() . ') '
                . 'is missing for theme ' . $this->getName()
            )
        );
    }

    /**
     * @return mixed
     */
    public function getPrimaryLayoutName()
    {
        return $this->getProperty(
            FieldsThemeComponent::PRIMARY_LAYOUT_NAME,
            LayoutComponent::PRIMARY_NAME
        );
    }

    /**
     * @return LayoutComponent
     * @throws DefaultLayoutMissingException
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
        return $this->getProperty(
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

        return Param::get(
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
    ): bool
    {
        $layoutVariations = $this->getLayoutVariations();

        return Param::has(
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
        $layoutVariations = Param::getArray(
            $this->properties,
            FieldsThemeComponent::LAYOUT_VARIATIONS,
            []
        );

        $layoutVariations = Param::set(
            $layoutVariations,
            $layoutComponent->getName(),
            $layoutComponent
        );

        $this->properties = Param::set(
            $this->properties,
            FieldsThemeComponent::LAYOUT_VARIATIONS,
            $layoutVariations
        );
    }
}
