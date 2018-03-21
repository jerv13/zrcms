<?php

namespace Zrcms\CoreResourceSearchFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigZrcms
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'zrcms-resource-search-fields' => [
                /* Example *
                '{Resource::class}' => [
                    'name' => '{fieldName}',
                    'type' => '{fieldType}',
                    'label' => '{label}',
                    //'required' => false,
                    //'default' => '{}',
                    'options' => [],
                ],
                /* */
            ],
        ];
    }
}
