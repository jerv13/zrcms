<?php

namespace Zrcms\CoreSiteContainer\Model;

use Zrcms\Core\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class SiteContainerCmsResourceBasic extends SiteContainerCmsResourceAbstract implements SiteContainerCmsResource
{
    /**
     * @param string|null                         $id
     * @param bool                                $published
     * @param SiteContainerVersion|ContentVersion $contentVersion
     * @param string                              $createdByUserId
     * @param string                              $createdReason
     * @param string|null                         $createdDate
     *
     * @throws \Zrcms\Core\Exception\ContentVersionInvalid
     */
    public function __construct(
        $id,
        bool $published,
        ContentVersion $contentVersion,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        parent::__construct(
            $id,
            $published,
            $contentVersion,
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }
}
