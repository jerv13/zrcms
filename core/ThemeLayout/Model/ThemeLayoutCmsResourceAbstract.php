<?php

namespace Zrcms\Core\ThemeLayout\Model;

use Zrcms\Content\Model\CmsResourceAbstract;
use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class LayoutCmsResourceAbstract extends CmsResourceAbstract implements ThemeLayoutCmsResource
{
    /**
     * @param string  $id
     * @param string  $source
     * @param ThemeLayout|Content $themeLayout
     * @param string  $createdByUserId
     * @param string  $createdReason
     */
    public function __construct(
        string $id,
        string $source,
        Content $themeLayout,
        string $createdByUserId,
        string $createdReason
    ) {

        parent::__construct(
            $id,
            $source,
            $themeLayout,
            $createdByUserId,
            $createdReason
        );
    }
}
