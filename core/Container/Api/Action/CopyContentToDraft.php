<?php

namespace Zrcms\Core\Container\Api\Action;

use Zrcms\ContentVersionControl\Model\Content;
use Zrcms\ContentVersionControl\Model\Draft;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CopyContentToDraft
{
    /**
     * @param Content  $content
     * @param string $modifiedByUserId
     * @param string $modifiedReason
     * @param array  $options
     *
     * @return Draft
     */
    public function __invoke(
        Content $content,
        string $modifiedByUserId,
        string $modifiedReason,
        array $options = []
    ): Draft;
}
