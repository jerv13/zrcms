<?php

namespace Zrcms\Core\Page\Api\Repository;

use Zrcms\Content\Model\ContentVersion;
use Zrcms\Core\Container\Api\Repository\InsertContainerVersion;
use Zrcms\Core\Page\Model\PageContainerVersionBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface InsertPageContainerVersion extends InsertContainerVersion
{
    /**
     * @param PageContainerVersionBasic|ContentVersion $pageContainerVersion
     * @param array                                    $options
     *
     * @return ContentVersion
     */
    public function __invoke(
        ContentVersion $pageContainerVersion,
        array $options = []
    ): ContentVersion;
}
