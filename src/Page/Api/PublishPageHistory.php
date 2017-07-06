<?php

namespace Rcms\Core\Page\Api;

use Rcms\Core\Page\Entity\PagePublished;
use Rcms\Core\Page\Model\PageHistory;

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
     * @return PagePublished
     */
    public function __invoke(
        PageHistory $page,
        string $modifiedByUserId,
        string $modifiedReason,
        array $options = []
    ): PagePublished;
}
