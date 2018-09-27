<?php

namespace Zrcms\CorePage;

use Zrcms\CoreContainer\Fields\FieldsContainer;
use Zrcms\CorePage\Api\Render\GetPageRenderTagsContainers;
use Zrcms\CorePage\Api\Render\GetPageRenderTagsHtml;
use Zrcms\CorePage\Fields\FieldsPageVersion;
use Zrcms\CorePage\Model\Page;
use Zrcms\CorePage\Model\ServiceAliasPage;
use Zrcms\ServiceAlias\Api\Validator\ValidateIsZrcmsServiceAlias;

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
            /**
             * ===== Field Models =====
             * ['{model-name}' => '{model-class}']
             */
            'field-rat-fields-model' => [
                FieldsPageVersion::FIELD_MODEL_NAME => FieldsPageVersion::class,
            ],

            /**
             * ===== Field Model Extends =====
             * ['{model-name}' => '{extends-model-name}']
             */
            'field-rat-fields-model-extends' => [
                FieldsPageVersion::FIELD_MODEL_NAME => 'content-version',
            ],

            /**
             * ===== Fields =====
             * ['{model-name}' => '{fields-config}']
             */
            'field-rat-fields' => [
                FieldsPageVersion::FIELD_MODEL_NAME => [
                    [
                        'name' => FieldsPageVersion::SITE_CMS_RESOURCE_ID,
                        'type' => 'id-string',
                        'label' => 'Site CmsResourceId',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsPageVersion::PATH,
                        'type' => 'text',
                        'label' => 'Path Identifier',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsPageVersion::TITLE,
                        'type' => 'text',
                        'label' => 'Title',
                        'required' => false,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsPageVersion::DESCRIPTION,
                        'type' => 'text',
                        'label' => 'Description',
                        'required' => false,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsPageVersion::KEYWORDS,
                        'type' => 'text',
                        'label' => 'Keywords',
                        'required' => false,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsPageVersion::LAYOUT,
                        'type' => 'text',
                        'label' => 'Layout',
                        'required' => false,
                        'default' => FieldsPageVersion::DEFAULT_PRIMARY_LAYOUT_NAME,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsPageVersion::CONTAINERS_DATA,
                        'type' => 'array',
                        'label' => 'Container Data',
                        'required' => true,
                        'default' => [
                            Page::DEFAULT_CONTAINER_NAME => [
                                FieldsContainer::BLOCK_VERSIONS => [],
                            ],
                        ],
                        'options' => [],
                    ],
                    [
                        'name' => FieldsPageVersion::RENDER_TAGS_GETTER,
                        'type' => 'zrcms-service',
                        'label' => 'Render Tags Getter (GetRenderTags)',
                        'required' => false,
                        'default' => FieldsPageVersion::DEFAULT_RENDER_TAGS_GETTER,
                        'options' => [
                            ValidateIsZrcmsServiceAlias::OPTION_SERVICE_ALIAS_NAMESPACE
                            => ServiceAliasPage::ZRCMS_CONTENT_RENDER_TAGS_GETTER
                        ],
                    ],
                    [
                        'name' => FieldsPageVersion::PAGE_CMS_RESOURCE_ID,
                        'type' => 'id-string',
                        'label' => 'Page CmsResourceId',
                        'required' => false,
                        'default' => '',
                        'options' => [],
                    ],
                ],
            ],

            /**
             * ===== Service Alias =====
             */
            'zrcms-service-alias' => [
                // 'zrcms.page.content.render-tags-getter'
                ServiceAliasPage::ZRCMS_CONTENT_RENDER_TAGS_GETTER => [
                    'containers'
                    => GetPageRenderTagsContainers::class,

                    'html'
                    => GetPageRenderTagsHtml::class,
                ],
            ],
        ];
    }
}
