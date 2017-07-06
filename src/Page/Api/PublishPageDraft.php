<?php

namespace Rcms\Core\Page\Api;

use Rcms\Core\Page\Model\PagePublished;
use Rcms\Core\Page\Model\PageDraft;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishPageDraft
{
    /**
     * @param PageDraft $page
     * @param string    $modifiedByUserId
     * @param string    $modifiedReason
     *
     * @return PagePublished
     */
    public function __invoke(
        PageDraft $page,
        string $modifiedByUserId,
        string $modifiedReason
    ): PagePublished;
}
