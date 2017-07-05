<?php

namespace Rcms\Core\Page\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface DeletePage
{
    /**
     * @param Page   $page
     * @param string $modifiedByUserId
     * @param string $modifiedReason
     *
     * @return Page
     */
    public function __invoke(
        Page $page,
        string $modifiedByUserId,
        string $modifiedReason
    ): Page;
}
