<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Model\ComponentAbstract;
use Zrcms\ContentCore\Theme\Exception\DefaultLayoutMissingException;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ThemeComponentAbstract extends ComponentAbstract implements ThemeComponent
{
    /**
     * @var array
     */
    protected $layoutVariations = [];

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
        $this->addLayoutVariations(
            Param::getRequired(
                $properties,
                PropertiesThemeComponent::LAYOUT_VARIATIONS
            )
        );

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );

        Param::assertHas(
            $properties,
            LayoutComponent::PRIMARY_NAME,
            new DefaultLayoutMissingException(
                "Primary layout is missing for theme " . $this->getName()
            )
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
        return $this->layoutVariations;
    }

    /**
     * @param string      $name
     * @param LayoutComponent|null $default
     *
     * @return LayoutComponent|null
     */
    public function getLayoutVariation(
        string $name,
        LayoutComponent $default = null
    ) {
        if ($this->hasLayoutVariation($name)) {
            return $this->layoutVariations[$name];
        }

        return $default;
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
        return array_key_exists($name, $this->layoutVariations);
    }

    /**
     * @param array $layouts
     *
     * @return void
     */
    protected function addLayoutVariations(array $layouts)
    {
        foreach ($layouts as $layout) {
            $this->addLayoutVariation($layout);
        }
    }

    /**
     * @param LayoutComponent $layout
     *
     * @return void
     */
    protected function addLayoutVariation(LayoutComponent $layout)
    {
        $this->layoutVariations[$layout->getName()] = $layout;
    }
}
