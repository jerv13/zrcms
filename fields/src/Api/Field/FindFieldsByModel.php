<?php

namespace Zrcms\Fields\Api\Field;

use Zrcms\Fields\Model\Fields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindFieldsByModel
{
    /**
     * @param string $model
     * @param array  $options
     *
     * @return Fields|null
     * @throws \Exception
     */
    public function __invoke(
        string $model,
        array $options = []
    );
}
