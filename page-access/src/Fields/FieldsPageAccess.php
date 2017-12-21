<?php

namespace Zrcms\PageAccess\Fields;

use Zrcms\Fields\Model\Fields;
use Zrcms\Fields\Model\FieldsAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsPageAccess extends FieldsAbstract implements Fields
{
    const PAGE_ACCESS = 'page-access';

    /**
     * @var array
     */
    protected $defaultFieldsConfig
        = [
            [
                'name' => self::PAGE_ACCESS,
                'type' => 'text',
                'label' => 'Page Access',
                'required' => false,
                'default' => [],
                'options' => [],
            ],
        ];
}
