<?php

namespace Zrcms\ContentCore\Page\Api\Repository;

use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Container\Api\Repository\InsertContainerVersion;
use Zrcms\ContentCore\Page\Model\PageVersionBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface InsertPageVersion extends InsertContainerVersion
{
    /**
     * @param PageVersionBasic|ContentVersion $pageVersion
     * @param array                           $options
     *
     * @return ContentVersion
     */
    public function __invoke(
        ContentVersion $pageVersion,
        array $options = []
    ): ContentVersion;
}
