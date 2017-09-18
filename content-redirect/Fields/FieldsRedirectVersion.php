<?php

namespace Zrcms\ContentRedirect\Fields;

use Zrcms\Content\Fields\FieldsContent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsRedirectVersion extends FieldsContent
{
    const REDIRECT_PATH = 'redirectPath';

    /**
     * @var array
     */
    protected $defaultFieldsConfig
        = [
            [
                'name' => self::REDIRECT_PATH,
                'type' => 'text',
                'label' => 'Redirect Path',
                'required' => true,
                'default' => '',
                'options' => [],
            ],
        ];
}
