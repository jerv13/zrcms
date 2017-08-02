<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ThemeComponent extends Component
{
    /**
     * Primary or Default layout
     *
     * @return LayoutComponent
     */
    public function getPrimaryLayout();

    /**
     * List of Layouts
     *
     * @return array
     */
    public function getLayoutVariations(): array;

    /**
     * @param string      $name
     * @param LayoutComponent|null $default
     *
     * @return LayoutComponent|null
     */
    public function getLayoutVariation(
        string $name,
        LayoutComponent $default = null
    );

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasLayoutVariation(
        string $name
    ): bool;


}
