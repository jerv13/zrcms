<?php

namespace Zrcms\ContentDoctrine\Entity;

use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ContentEntityBasic extends ContentEntityAbstract implements ContentEntity
{
    /**
     * @param ContentVersion $contentVersion
     */
    public function __construct(
        ContentVersion $contentVersion
    ) {
        parent::__construct(
            $contentVersion
        );
    }
}
