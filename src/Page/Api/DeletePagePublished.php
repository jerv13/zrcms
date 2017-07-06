<?php

namespace Rcms\Core\Page\Api;

use Rcms\Core\Page\Model\PageDeleted;
use Rcms\Core\Page\Model\PagePublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface DeletePagePublished
{
    /**
     * @param PagePublished $page
     * @param string        $modifiedByUserId
     * @param string        $modifiedReason
     * @param array         $options
     *
     * @return PageDeleted
     */
    public function __invoke(
        PagePublished $page,
        string $modifiedByUserId,
        string $modifiedReason,
        array $options = []
    ): PageDeleted;
}
