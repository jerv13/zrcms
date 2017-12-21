<?php

namespace Zrcms\Fields\Api;

use Zrcms\Fields\Model\Fields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetFields
{
    /**
     * @param string $model
     * @param array  $options
     *
     * @return Fields
     *
     */
    public function __invoke(
        string $model,
        array $options = []
    ): Fields;
}
