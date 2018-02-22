<?php

namespace Zrcms\CoreAdminTools\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreAdminTools\Api\Acl\IsAllowedAdminTools;
use Zrcms\CoreApplicationState\Api\GetApplicationState;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetApplicationStateAdminTools implements GetApplicationState
{
    const APPLICATION_STATE_KEY = 'admin-tools';

    protected $isAllowedAdminTools;
    protected $sortAdminToolsMenu;
    protected $adminToolsMenuConfig;

    /**
     * @param IsAllowedAdminTools $isAllowedAdminTools
     * @param SortAdminToolsMenu  $sortAdminToolsMenu
     * @param array               $adminToolsMenuConfig
     */
    public function __construct(
        IsAllowedAdminTools $isAllowedAdminTools,
        SortAdminToolsMenu $sortAdminToolsMenu,
        array $adminToolsMenuConfig
    ) {
        $this->isAllowedAdminTools = $isAllowedAdminTools;
        $this->sortAdminToolsMenu = $sortAdminToolsMenu;
        $this->adminToolsMenuConfig = $adminToolsMenuConfig;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): array {
        $adminToolsAppState = [];

        $allowed = $this->isAllowedAdminTools->__invoke(
            $request
        );

        $adminToolsAppState['allowed'] = $allowed;

        return $adminToolsAppState;
    }
}
