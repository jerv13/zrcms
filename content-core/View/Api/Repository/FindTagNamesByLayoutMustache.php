<?php

namespace Zrcms\ContentCore\View\Api\Repository;

use Zrcms\ContentCore\Theme\Model\Layout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContainerPathsByHtmlMustache implements FindTagNamesByLayout
{
    /**
     * @param Layout $layout
     * @param array  $options
     *
     * @return string[] ['{container-path}']
     */
    public function __invoke(Layout $layout, array $options = []): array
    {
        // '/\{\{' . PropertiesContainer::RENDER_NAMESPACE . '.([^}:]+)\}\}/'
        preg_match_all(
            '/\{\{([^}:]+)\}\}/',
            $layout->getHtml(),
            $matches
        );

        return $matches[1];
    }
}
