<?php

namespace Zrcms\ContentCore\Page\Fields;

use Zrcms\Content\Fields\Fields;
use Zrcms\Content\Fields\FieldsAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsPageTemplateCmsResource extends FieldsAbstract implements Fields 
{
    const SITE_CMS_RESOURCE_ID = 'siteCmsResourceId';
    const PATH = 'path';

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
                'name' => self::PATH,
                'type' => 'text',
                'label' => 'Path Identifier',
                'required' => true,
                'default' => '',
                'options' => [],
            ],
        ];
}
