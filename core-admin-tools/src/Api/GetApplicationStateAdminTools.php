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

    /**
     * @param IsAllowedAdminTools $isAllowedAdminTools
     */
    public function __construct(
        IsAllowedAdminTools $isAllowedAdminTools
    ) {
        $this->isAllowedAdminTools = $isAllowedAdminTools;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $appState
     * @param array                  $options
     *
     * @return array
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $appState = [],
        array $options = []
    ): array {
        $adminToolsAppState = [];

        $adminToolsAppState['is-allowed'] = $this->isAllowedAdminTools->__invoke(
            $request
        );

        $appState[static::APPLICATION_STATE_KEY] = $adminToolsAppState;

        return $appState;
    }
}
