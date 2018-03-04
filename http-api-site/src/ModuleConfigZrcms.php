<?php

namespace Zrcms\HttpApiSite;

use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;
use Zrcms\Core\Api\CmsResource\CmsResourcesToArray;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\Content\ContentVersionsToArray;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResource;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourcesBy;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourcesPublished;
use Zrcms\CoreSite\Api\CmsResource\UpsertSiteCmsResource;
use Zrcms\CoreSite\Api\Content\FindSiteVersion;
use Zrcms\CoreSite\Api\Content\FindSiteVersionsBy;
use Zrcms\CoreSite\Api\Content\InsertSiteVersion;
use Zrcms\CoreSite\Fields\FieldsSiteVersion;
use Zrcms\ValidationRatZrcms\Api\FieldValidator\ValidateFieldsInsertContentVersionData;
use Zrcms\ValidationRatZrcms\Api\FieldValidator\ValidateFieldsUpsertCmsResourceData;

/**
 * @author James Jervis - https:/github.com/jerv13
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
             * ===== ZRCMS HTTP API by request =====
             */
            'zrcms-http-api-dynamic' => [
                'site' => [
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
                            'api-service' => FindSiteCmsResource::class,
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
                            'api-service' => FindSiteCmsResourcesBy::class,
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
                            'api-service' => FindSiteCmsResourcesPublished::class,
                            'to-array' => CmsResourcesToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],

                    'upsert-cms-resource' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserSitesAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'fields-validator' => [
                            'fields-validator' => ValidateFieldsUpsertCmsResourceData::class,
                            'fields-validator-options' => [
                                'validator-options-content-version-id' => [
                                    'api-service-find-content-version' => FindSiteVersion::class,
                                ],
                            ],
                            'not-valid-status' => 400,
                        ],
                        'api' => [
                            'api-service-find-content-version' => FindSiteVersion::class,
                            'api-service' => UpsertSiteCmsResource::class,
                            'to-array' => CmsResourceToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],

                    /**
                     * CmsResourceHistory
                     */
                    'find-cms-resource-history' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserSitesAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'api' => [
                            //'api-service' => TBD::class,
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
                            //'api-service' => TBD::class,
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
                            'api-service' => FindSiteVersion::class,
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
                            'api-service' => FindSiteVersionsBy::class,
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
                                    'fields-model-name' => FieldsSiteVersion::FIELD_MODEL_NAME
                                ],
                            ],
                            'not-valid-status' => 400,
                        ],
                        'api' => [
                            'api-service' => InsertSiteVersion::class,
                            'to-array' => ContentVersionToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],
                ],
            ],
        ];
    }
}
