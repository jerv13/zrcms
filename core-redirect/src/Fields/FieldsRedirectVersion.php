<?php

namespace Zrcms\CoreRedirect\Fields;

use Zrcms\Core\Fields\FieldsContent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsRedirectVersion extends FieldsContent
{
    const SITE_CMS_RESOURCE_ID = 'siteCmsResourceId';
    const REQUEST_PATH = 'requestPath';
    const REDIRECT_PATH = 'redirectPath';

    /**
     * @var array
     */
    protected $defaultFieldsConfig
        = [
            [
                'name' => self::SITE_CMS_RESOURCE_ID,
                'type' => 'id',
                'label' => 'Site CmsResourceId',
                'required' => true,
                'default' => '',
                'options' => [],
            ],
            [
                'name' => self::REQUEST_PATH,
                'type' => 'text',
                'label' => 'Request Path',
                'required' => true,
                'default' => '',
                'options' => [],
            ],
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
