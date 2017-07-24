<?php

namespace Zrcms\Content\Api\Action;

use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResource;
use Zrcms\ContentDoctrine\Api\Action\PublishContentVersion;

/**
 * If ContentVersion does not exist, throw ContentVersionNotExistsException
 * Unpublish (delete) CmsResource if exists
 * Create CmsResource (or recreate) WARNING: foreign keys constraints can not be used
 * Make CmsResourcePublishHistory entry
 * Save CmsResource
 *
 * @author James Jervis - https://github.com/jerv13
 */
class PublishPageContainerVersion
    extends PublishContentVersion
    implements \Zrcms\ContentCore\Page\Api\Action\PublishPageContainerVersion
{
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            $entityClassCmsResource,
            $entityClassCmsResourcePublishHistory,
            $entityClassContentVersion,
            $classCmsResourceBasic
        );
    }

    /**
     * @param PageContainerCmsResource|CmsResource $pageContainerCmsResource
     * @param string                               $publishedByUserId
     * @param string                               $publishReason
     *
     * @return CmsResource
     */
    public function __invoke(
        CmsResource $pageContainerCmsResource,
        string $publishedByUserId,
        string $publishReason
    ): CmsResource
    {
        return parent::__invoke(
            $pageContainerCmsResource,
            $publishedByUserId,
            $publishReason
        );
    }
}
