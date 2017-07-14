<?php

namespace Zrcms\Core\Container\Api\Repository;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContainerPathsByHtmlMustache implements FindContainerPathsByHtml
{
    /**
     * @param string $html
     * @param array $options
     *
     * @return array ['{container-name}']
     */
    public function __invoke(string $html, array $options = [])
    {
        preg_match_all('/\{\{container.([^}:]+)\}\}/', $html, $matches);

        return $matches[1];
    }
}
