<?php

namespace Zrcms\CoreView\Api;

use Zrcms\CoreTheme\Model\Layout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetTagNamesByLayoutMustache implements GetTagNamesByLayout
{
    /**
     * @param Layout $layout
     * @param array  $options
     *
     * @return string[] ['{container-path}']
     */
    public function __invoke(
        Layout $layout,
        array $options = []
    ): array {
        // @todo @missing-containers this needs to cache
        // '/\{\{' . PropertiesContainer::RENDER_NAMESPACE . '.([^}:]+)\}\}/'
        preg_match_all(
            '/\{\{([^{^}:]+)\}\}/',
            $layout->getHtml(),
            $matches
        );

        return $matches[1];
    }
}
