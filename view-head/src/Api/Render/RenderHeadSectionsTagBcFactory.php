<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderHeadSectionsTagBcFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RenderHeadSectionsTagBc
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $availableSectionsBc = [];

        if (array_key_exists('Rcm', $config)) {
            if (array_key_exists('HtmlIncludes', $config['Rcm'])) {
                $availableSectionsBc = $config['Rcm']['HtmlIncludes']['sections'];
            }
        }

        return new RenderHeadSectionsTagBc(
            $serviceContainer->get(RenderTag::class),
            $config['zrcms-head-available-sections'],
            $availableSectionsBc
        );
    }
}
