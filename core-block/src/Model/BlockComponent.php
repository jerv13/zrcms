<?php

namespace Zrcms\CoreBlock\Model;

use Zrcms\Core\Model\Component;

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
