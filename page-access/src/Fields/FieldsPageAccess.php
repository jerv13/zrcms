<?php

namespace Zrcms\PageAccess\Fields;

use Zrcms\Fields\Model\Fields;
use Zrcms\Fields\Model\FieldsAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsPageAccess extends FieldsAbstract implements Fields
{
    const PAGE_ACCESS_OPTIONS = 'page-access-options';

    /**
     * @var array
     */
    protected $defaultFieldsConfig
        = [
            [
                'name' => self::PAGE_ACCESS_OPTIONS,
                'type' => 'text',
                'label' => 'Page Access Options',
                'required' => false,
                'default' => [],
                'options' => [],
            ],
        ];
}
