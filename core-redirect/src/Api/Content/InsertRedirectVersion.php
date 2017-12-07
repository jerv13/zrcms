<?php

namespace Zrcms\CoreRedirect\Api\Content;

use Zrcms\Core\Api\Content\InsertContentVersion;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreRedirect\Model\RedirectVersion;

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
