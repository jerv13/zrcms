<?php

namespace Zrcms\ContentVersionControl\Api;

use Zrcms\ContentVersionControl\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CopyContentToContent
{
    const REASON_NAME = '[CopyContentToDraft]';

    /**
     * @param Content $content
     * @param string  $modifiedByUserId
     * @param string  $modifiedReason
     * @param array   $options
     *
     * @return Content
     */
    public function __invoke(
        Content $content,
        string $modifiedByUserId,
        string $modifiedReason,
        array $options = []
    ): Content;
}
