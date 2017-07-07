<?php

namespace Zrcms\Core\Block\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderLayout
{
    public function __invoke(
        Site $site,
        Page $page
    );
}
