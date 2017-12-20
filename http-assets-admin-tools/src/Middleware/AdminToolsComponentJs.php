<?php

namespace Zrcms\HttpAssetsAdminTools\Middleware;

use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\CoreAdminTools\Api\GetComponentJsAdminTools;
use Zrcms\HttpAssets\Middleware\ComponentJs;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class AdminToolsComponentJs extends ComponentJs
{
    /**
     * @param FindComponentsBy         $findComponentsBy
     * @param GetComponentJsAdminTools $getComponentJs
     * @param array                    $headers
     */
    public function __construct(
        FindComponentsBy $findComponentsBy,
        GetComponentJsAdminTools $getComponentJs,
        array $headers = ['content-type' => 'text/javascript']
    ) {
        parent::__construct(
            $findComponentsBy,
            $getComponentJs,
            $headers
        );
    }
}
