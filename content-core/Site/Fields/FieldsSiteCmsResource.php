<?php

namespace Zrcms\ContentCore\Site\Fields;

use Zrcms\Content\Fields\FieldsCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsSiteCmsResource extends FieldsCmsResource
{
    const HOST = 'host';

    /**
     * @var array
     */
    protected $defaultFieldsConfig
        = [
            [
                'name' => self::HOST,
                'type' => 'text',
                'label' => 'Host Name',
                'required' => true,
                'default' => '',
                'options' => [],
            ],
        ];
}
