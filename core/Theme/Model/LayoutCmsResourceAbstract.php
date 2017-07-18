<?php

namespace Zrcms\Core\Theme\Model;

use Zrcms\Content\Model\CmsResourceAbstract;
use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class LayoutCmsResourceAbstract extends CmsResourceAbstract implements LayoutCmsResource
{
    /**
     * @param string  $uri
     * @param string  $source
     * @param Content $layout
     * @param string  $createdByUserId
     * @param string  $createdReason
     */
    public function __construct(
        string $uri,
        string $source,
        Content $layout,
        string $createdByUserId,
        string $createdReason
    ) {

        parent::__construct(
            $uri,
            $source,
            $layout,
            $createdByUserId,
            $createdReason
        );
    }
}
