<?php

namespace Zrcms\HttpAssetsBlock\Middleware;

use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\Core\Api\GetComponentJs;
use Zrcms\HttpAssets\Middleware\ComponentJs;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BlockJs extends ComponentJs
{
    /**
     * @param FindComponentsBy $findComponentsBy
     * @param GetComponentJs   $getComponentJs
     * @param array            $headers
     */
    public function __construct(
        FindComponentsBy $findComponentsBy,
        GetComponentJs $getComponentJs,
        array $headers = ['content-type' => 'text/javascript']
    ) {
        parent::__construct(
            $findComponentsBy,
            $getComponentJs,
            'block',
            $headers
        );
    }
}
