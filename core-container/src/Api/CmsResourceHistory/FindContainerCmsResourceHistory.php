<?php

namespace Zrcms\CoreContainer\Api\CmsResourceHistory;

use Zrcms\Core\Api\CmsResourceHistory\FindCmsResourceHistory;
use Zrcms\CoreContainer\Model\ContainerCmsResourceHistory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindContainerCmsResourceHistory extends FindCmsResourceHistory
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return ContainerCmsResourceHistory|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
