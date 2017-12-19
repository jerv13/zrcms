<?php

namespace Zrcms\HttpAssetsBlock\Middleware;

use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\Core\Api\GetComponentCss;
use Zrcms\HttpAssets\Middleware\ComponentCss;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BlockCss extends ComponentCss
{
    /**
     * @param FindComponentsBy $findComponentsBy
     * @param GetComponentCss  $getComponentCss
     * @param array            $headers
     */
    public function __construct(
        FindComponentsBy $findComponentsBy,
        GetComponentCss $getComponentCss,
        array $headers = ['content-type' => 'text/css']
    ) {
        parent::__construct(
            $findComponentsBy,
            $getComponentCss,
            'block',
            $headers
        );
    }
}
