<?php

namespace Zrcms\CoreContainer;

use Zrcms\CoreContainer\Api\Render\GetContainerRenderTagsBlocks;
use Zrcms\CoreContainer\Api\Render\RenderContainerRows;
use Zrcms\CoreContainer\Fields\FieldsContainerVersion;
use Zrcms\CoreContainer\Model\ServiceAliasContainer;

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
             * ===== ZRCMS Field Models =====
             * ['{model-name}' => '{model-class}']
             */
            'zrcms-fields-model' => [
                'container-version' => FieldsContainerVersion::class,
            ],

            /**
             * ===== ZRCMS Field Model Extends =====
             * ['{model-name}' => '{extends-model-name}']
             */
            'zrcms-fields-model-extends' => [
                'container-version' => 'content-version',
            ],

            /**
             * ===== ZRCMS Fields =====
             * ['{model-name}' => '{fields-config}']
             */
            'zrcms-fields' => [
                'container-version' => [
                    [
                        'name' => FieldsContainerVersion::RENDER_TAGS_GETTER,
                        'type' => 'zrcms-service',
                        'label' => 'Render Tags Getter (GetRenderTags)',
                        'required' => false,
                        'default' => FieldsContainerVersion::DEFAULT_RENDER_TAGS_GETTER,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsContainerVersion::RENDERER,
                        'type' => 'zrcms-service',
                        'label' => 'Renderer',
                        'required' => false,
                        'default' => FieldsContainerVersion::DEFAULT_RENDERER,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsContainerVersion::BLOCK_VERSIONS,
                        'type' => 'array',
                        'label' => 'Block Versions',
                        'required' => false,
                        'default' => FieldsContainerVersion::DEFAULT_BLOCK_VERSIONS,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsContainerVersion::SITE_CMS_RESOURCE_ID,
                        'type' => 'id',
                        'label' => 'Container CmsResourceId',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsContainerVersion::PATH,
                        'type' => 'text',
                        'label' => 'Path Identifier',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                ],
            ],

            /**
             * ===== Service Alias =====
             */
            'zrcms-service-alias' => [
                // 'zrcms.container.content.render-tags-getter'
                ServiceAliasContainer::ZRCMS_CONTENT_RENDER_TAGS_GETTER => [
                    'block'
                    => GetContainerRenderTagsBlocks::class,
                ],
                // 'zrcms.container.content.renderer'
                ServiceAliasContainer::ZRCMS_CONTENT_RENDERER => [
                    'rows'
                    => RenderContainerRows::class,
                ],
            ],
        ];
    }
}
