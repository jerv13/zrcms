<?php

namespace Zrcms\Fields\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PrepareFields
{
    /**
     * @param array $fields ['{name}' => '{value}']
     * @param array $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        array $fields,
        array $options = []
    ): array;
}
