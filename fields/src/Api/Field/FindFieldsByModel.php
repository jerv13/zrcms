<?php

namespace Zrcms\Fields\Api\Field;

use Zrcms\Fields\Model\Fields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindFieldsByModel
{
    /**
     * @param string $modelName
     * @param array  $options
     *
     * @return Fields|null
     * @throws \Exception
     */
    public function __invoke(
        string $modelName,
        array $options = []
    );
}
