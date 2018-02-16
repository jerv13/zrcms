<?php

namespace Zrcms\CoreAdminTools\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class SortAdminToolsMenuNoop implements SortAdminToolsMenu
{
    /**
     * @param array $adminToolsMenuConfig
     * @param array $option
     *
     * @return array
     */
    public function __invoke(
        array $adminToolsMenuConfig,
        array $option = []
    ): array {
        return $adminToolsMenuConfig;
    }
}
