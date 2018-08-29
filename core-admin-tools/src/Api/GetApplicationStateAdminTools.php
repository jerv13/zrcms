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
    const APPLICATION_STATE_KEY = 'adminTools';

    protected $isAllowedAdminTools;
    protected $debug;

    /**
     * @param IsAllowedAdminTools $isAllowedAdminTools
     * @param bool                $debug
     */
    public function __construct(
        IsAllowedAdminTools $isAllowedAdminTools,
        bool $debug = false
    ) {
        $this->isAllowedAdminTools = $isAllowedAdminTools;
        $this->debug = $debug;
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

        if ($this->debug) {
            $adminToolsAppState['debug-source'] = get_class($this);
        }

        return $adminToolsAppState;
    }
}
