<?php

namespace Zrcms\CoreTheme\Model;

use Zrcms\Core\Exception\PropertyMissing;
use Zrcms\Core\Model\ComponentAbstract;
use Zrcms\CoreTheme\Exception\DefaultLayoutMissing;
use Zrcms\CoreTheme\Fields\FieldsThemeComponent;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ThemeComponentAbstract extends ComponentAbstract
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

        Param::assertHas(
            $this->getLayoutVariations(),
            $this->getPrimaryLayoutName(),
            new DefaultLayoutMissing(
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
