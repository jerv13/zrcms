<?php

namespace Zrcms\Core\Layout\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindContainerPathsByHtml
{
    /**
     * @param string $html
     * @param array  $options
     *
     * @return array ['{container-name}']
     */
    public function __invoke(string $html, array $options = []);
}
