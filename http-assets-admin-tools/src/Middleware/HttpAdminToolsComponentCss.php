<?php

namespace Zrcms\HttpAssetsAdminTools\Middleware;

use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\CoreAdminTools\Api\GetComponentCssAdminTools;
use Zrcms\HttpAssets\Middleware\HttpComponentCss;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpAdminToolsComponentCss extends HttpComponentCss
{
    /**
     * @param FindComponentsBy          $findComponentsBy
     * @param GetComponentCssAdminTools $getComponentJs
     * @param array                     $headers
     */
    public function __construct(
        FindComponentsBy $findComponentsBy,
        GetComponentCssAdminTools $getComponentJs,
        array $headers = ['content-type' => 'text/javascript']
    ) {
        parent::__construct(
            $findComponentsBy,
            $getComponentJs,
            $headers
        );
    }
}
