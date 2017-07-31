<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Content\Model\ComponentAbstract;
use Zrcms\ContentCore\Theme\Exception\DefaultLayoutMissingException;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ThemeComponentAbstract extends ComponentAbstract implements ThemeComponent
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
            PropertiesThemeComponent::LAYOUT_VARIATIONS,
            new PropertyMissingException(
                'Required property (' . PropertiesThemeComponent::LAYOUT_VARIATIONS . ') is missing in: '
                . get_class($this)
            )
        );

        $layoutVariations = Param::getArray(
            $properties,
            PropertiesThemeComponent::LAYOUT_VARIATIONS,
            []
        );

        $this->assertAreLayoutVariations($layoutVariations);

        Param::assertHas(
            $layoutVariations,
            LayoutComponent::PRIMARY_NAME,
            new DefaultLayoutMissingException(
                "Primary layout is missing for theme " . $this->getName()
            )
        );

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return LayoutComponent
     * @throws DefaultLayoutMissingException
     */
    public function getLayout()
    {
        return $this->getLayoutVariation(LayoutComponent::PRIMARY_NAME);
    }

    /**
     * List of Layouts
     *
     * @return array
     */
    public function getLayoutVariations(): array
    {
        return $this->getProperty(
            PropertiesThemeComponent::LAYOUT_VARIATIONS,
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
     * @param array $layoutVariations
     *
     * @return void
     * @throws \Exception
     */
    protected function assertAreLayoutVariations(array $layoutVariations)
    {
        /** @var LayoutComponent $layoutVariation */
        foreach ($layoutVariations as $layoutVariation) {
            if (!is_a($layoutVariation, LayoutComponent::class)) {
                throw new \Exception(
                    'Layout variations must be object of type: ' . LayoutComponent::class
                );
            }
        }
    }
}
