<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class LayoutCmsResourceBasic extends LayoutCmsResourceAbstract implements LayoutCmsResource
{
    /**
     * @param string|null                  $id
     * @param bool                         $published
     * @param LayoutVersion|ContentVersion $contentVersion
     * @param string                       $createdByUserId
     * @param string                       $createdReason
     * @param string|null                  $createdDate
     */
    public function __construct(
        $id,
        bool $published,
        ContentVersion $contentVersion,
        string $createdByUserId,
        string $createdReason,
        string $createdDate = null
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
