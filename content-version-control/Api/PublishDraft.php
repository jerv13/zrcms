<?php

namespace Zrcms\ContentVersionControl\Api;

use Zrcms\ContentVersionControl\Model\Content;
use Zrcms\ContentVersionControl\Model\Draft;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishDraft
{
    const REASON_NAME = '[PublishDraft]';

    /**
     * @param Draft  $content
     * @param string $modifiedByUserId
     * @param string $modifiedReason
     * @param array  $options
     *
     * @return Content
     */
    public function __invoke(
        Draft $content,
        string $modifiedByUserId,
        string $modifiedReason,
        array $options = []
    ): Content;
}
