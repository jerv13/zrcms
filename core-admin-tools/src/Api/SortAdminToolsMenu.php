<?php

namespace Zrcms\CoreAdminTools\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface SortAdminToolsMenu
{
    /**
     * Allow the admin menus to be sorted so they can be displayed in the desired order
     *
     * @param array $adminToolsMenuConfig
     * @param array $option
     *
     * @return array
     */
    public function __invoke(
        array $adminToolsMenuConfig,
        array $option = []
    ): array;
}
