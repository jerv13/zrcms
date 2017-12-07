<?php

namespace Zrcms\CoreSite\Model;

use Zrcms\Core\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class SiteCmsResourceBasic extends SiteCmsResourceAbstract implements SiteCmsResource
{
    /**
     * @param string|null    $id
     * @param bool           $published
     * @param SiteVersion|ContentVersion $contentVersion
     * @param string         $createdByUserId
     * @param string         $createdReason
     * @param string|null    $createdDate
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
