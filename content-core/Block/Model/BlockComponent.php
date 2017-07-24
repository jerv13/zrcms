<?php

namespace Zrcms\ContentCore\Block\Model;

use Zrcms\Content\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BlockComponent extends Component
{
    /**
     * Default config values
     *
     * @return array
     */
    public function getDefaultConfig(): array;

    /**
     * @return bool
     */
    public function isCacheable(): bool;
}
