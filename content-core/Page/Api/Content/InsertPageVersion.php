<?php

namespace Zrcms\ContentCore\Page\Api\Content;

use Zrcms\Content\Api\Content\InsertContentVersion;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Page\Model\PageVersionBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface InsertPageVersion extends InsertContentVersion
{
    /**
     * @param PageVersionBasic|ContentVersion $pageVersion
     * @param array                           $options
     *
     * @return PageVersionBasic|ContentVersion
     */
    public function __invoke(
        ContentVersion $pageVersion,
        array $options = []
    ): ContentVersion;
}
