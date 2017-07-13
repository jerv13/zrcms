<?php

namespace Zrcms\Core\Page\Api;

use Zrcms\Core\Page\Model\Page;
use Zrcms\Core\Page\Model\PageHistory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishPageHistory
{
    /**
     * @param PageHistory $page
     * @param string      $modifiedByUserId
     * @param string      $modifiedReason
     * @param array       $options
     *
     * @return Page
     */
    public function __invoke(
        PageHistory $page,
        string $modifiedByUserId,
        string $modifiedReason,
        array $options = []
    ): PagePublished;
}
