<?php

namespace Zrcms\CorePage\Api\Content;

use Zrcms\Core\Api\Content\InsertContentVersion;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CorePage\Model\PageVersionBasic;

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
