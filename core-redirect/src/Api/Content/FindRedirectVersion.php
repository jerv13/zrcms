<?php

namespace Zrcms\CoreRedirect\Api\Content;

use Zrcms\Core\Api\Content\FindContentVersion;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreRedirect\Model\RedirectVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindRedirectVersion extends FindContentVersion
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return RedirectVersion|ContentVersion|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
