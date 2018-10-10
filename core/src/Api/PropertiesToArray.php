<?php

namespace Zrcms\Core\Api;

use Zrcms\Core\Model\Properties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PropertiesToArray
{
    const OPTION_HIDE_PROPERTIES = 'hideProperties';
    const OPTION_SHOW_PRIVATE = 'showPrivate';
    const PRIVATE_PREFIX = Properties::PRIVATE_PREFIX;

    /**
     * @param array $properties
     * @param array $options
     *
     * @return array
     */
    public function __invoke(
        array $properties,
        array $options = []
    ): array;
}
