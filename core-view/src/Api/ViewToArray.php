<?php

namespace Zrcms\CoreView\Api;

use Zrcms\CoreView\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ViewToArray
{
    const OPTION_HIDE_PROPERTIES = 'hideProperties';

    /**
     * @param View  $view
     * @param array $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        View $view,
        array $options = []
    ): array;
}
