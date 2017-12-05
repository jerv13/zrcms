<?php

namespace Zrcms\ContentCore\Block\Api\Component;

use Zrcms\Content\Api\Component\PrepareComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PrepareComponentConfigBlock extends PrepareComponentConfig
{
    /**
     * @param array $blockConfig
     * @param array $options
     *
     * @return array
     */
    public function __invoke(
        array $blockConfig,
        array $options = []
    ): array;
}
