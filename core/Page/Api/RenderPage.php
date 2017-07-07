<?php

namespace Zrcms\Core\Container\Api;

use Zrcms\Core\Page\Model\Page;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderPage
{
    /**
     * @param Page  $page
     * @param array $options
     *
     * @return string
     */
    public function __invoke(
        Page $page,
        array $options = []
    ): string;
}
