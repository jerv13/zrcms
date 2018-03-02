<?php

namespace Zrcms\HttpApiContainer;

use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;
use Zrcms\Core\Api\CmsResource\CmsResourcesToArray;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\Content\ContentVersionsToArray;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\Core\Fields\FieldsContentVersion;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResource;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResourcesBy;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResourcesPublished;
use Zrcms\CoreContainer\Api\CmsResource\UpsertContainerCmsResource;
use Zrcms\CoreContainer\Api\CmsResourceHistory\FindContainerCmsResourceHistory;
use Zrcms\CoreContainer\Api\CmsResourceHistory\FindContainerCmsResourceHistoryBy;
use Zrcms\CoreContainer\Api\Content\FindContainerVersion;
use Zrcms\CoreContainer\Api\Content\FindContainerVersionsBy;
use Zrcms\CoreContainer\Api\Content\InsertContainerVersion;
use Zrcms\CoreContainer\Fields\FieldsContainerVersion;
use Zrcms\ValidationRatZrcms\Api\FieldValidator\ValidateFieldsUpsertCmsResourceData;
use Zrcms\ValidationRatZrcms\Api\FieldValidator\ValidateFieldsInsertContentVersionData;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigZrcms
{
    public function __invoke()
    {
        return [
            /**
             * ===== ZRCMS HTTP API by request =====
             */
            'zrcms-http-api-dynamic' => [
                'container' => [
                    /**
                     * CmsResource
                     */
                    'find-cms-resource' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserSitesAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'api' => [
                            'api-service' => FindContainerCmsResource::class,
                            'to-array' => CmsResourceToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],

                    'find-cms-resources-by' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserSitesAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'api' => [
                            'api-service' => FindContainerCmsResourcesBy::class,
                            'to-array' => CmsResourcesToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],

                    'find-cms-resources-published' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserSitesAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'api' => [
                            'api-service' => FindContainerCmsResourcesPublished::class,
                            'to-array' => CmsResourcesToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],

                    /**
                     * CmsResourceHistory
                     */
                    'upsert-cms-resource' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserSitesAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'fields-validator' => [
                            'fields-validator' => ValidateFieldsUpsertCmsResourceData::class,
                            'fields-validator-options' => [
                                'fields-validator-options-insert-content-version-properties' => [
                                    'fields-model-name' => FieldsContainerVersion::FIELD_MODEL_NAME
                                ],
                            ],
                            'not-valid-status' => 400,
                        ],
                        'api' => [
                            'api-service' => UpsertContainerCmsResource::class,
                            'to-array' => CmsResourceToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],

                    'find-cms-resource-history' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserSitesAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'api' => [
                            'api-service' => FindContainerCmsResourceHistory::class,
                            'to-array' => CmsResourceToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],

                    'find-cms-resource-histories-by' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserSitesAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'api' => [
                            'api-service' => FindContainerCmsResourceHistoryBy::class,
                            'to-array' => CmsResourcesToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],

                    /**
                     * ContentVersion
                     */
                    'find-content-version' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserSitesAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'api' => [
                            'api-service' => FindContainerVersion::class,
                            'to-array' => ContentVersionToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],

                    'find-content-versions-by' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserSitesAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'api' => [
                            'api-service' => FindContainerVersionsBy::class,
                            'to-array' => ContentVersionsToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],

                    'insert-content-version' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserSitesAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'fields-validator' => [
                            'fields-validator' => ValidateFieldsInsertContentVersionData::class,
                            'fields-validator-options' => [
                                'fields-validator-options-properties' => [
                                    'fields-model-name' => FieldsContainerVersion::FIELD_MODEL_NAME
                                ],
                            ],
                            'not-valid-status' => 400,
                        ],
                        'api' => [
                            'api-service' => InsertContainerVersion::class,
                            'to-array' => ContentVersionToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],
                ],
            ],
        ];
    }
}
