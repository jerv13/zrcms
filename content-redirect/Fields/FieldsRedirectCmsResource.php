<?php

namespace Zrcms\ContentRedirect\Fields;

use Zrcms\Content\Fields\FieldsCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsRedirectCmsResource extends FieldsCmsResource
{
    const SITE_CMS_RESOURCE_ID = 'siteCmsResourceId';
    const REQUEST_PATH = 'requestPath';

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
        ];
}
