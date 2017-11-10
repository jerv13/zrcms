<?php

namespace Zrcms\ContentRedirect\Api\Repository;

use Zrcms\Content\Api\Repository\InsertContentVersion;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentRedirect\Model\RedirectVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface InsertRedirectVersion extends InsertContentVersion
{
    /**
     * @param RedirectVersion|ContentVersion $redirectVersion
     * @param array                      $options
     *
     * @return RedirectVersion|ContentVersion
     */
    public function __invoke(
        ContentVersion $redirectVersion,
        array $options = []
    ): ContentVersion;
}
