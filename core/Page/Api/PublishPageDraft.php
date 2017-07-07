<?php

namespace Zrcms\Core\Page\Api;

use Zrcms\Core\Page\Model\PagePublished;
use Zrcms\Core\Page\Model\PageDraft;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishPageDraft
{
    /**
     * @param PageDraft $page
     * @param string    $modifiedByUserId
     * @param string    $modifiedReason
     * @param array     $options
     *
     * @return PagePublished
     */
    public function __invoke(
        PageDraft $page,
        string $modifiedByUserId,
        string $modifiedReason,
        array $options = []
    ): PagePublished;
}
