<?php

namespace Zrcms\Core\Container\Api\Repository;

use Zrcms\Core\Container\Model\ContainerProperties;
use Zrcms\Core\ThemeLayout\Model\Layout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContainerPathsByHtmlMustache implements FindTagNamesByLayout
{
    /**
     * @param Layout $layout
     * @param array  $options
     *
     * @return array ['{container-path}']
     */
    public function __invoke(Layout $layout, array $options = [])
    {
        // '/\{\{' . ContainerProperties::RENDER_NAMESPACE . '.([^}:]+)\}\}/'
        preg_match_all(
            '/\{\{([^}:]+)\}\}/',
            $layout->getHtml(),
            $matches
        );

        return $matches[1];
    }
}
