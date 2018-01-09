<?php

namespace Zrcms\Core\Api\CmsResourceHistory;

use Zrcms\Core\Model\CmsResourceHistory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindCmsResourceHistory
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return CmsResourceHistory|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
