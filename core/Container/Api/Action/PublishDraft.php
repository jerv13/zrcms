<?php

namespace Zrcms\Core\Container\Api\Action;

use Zrcms\ContentVersionControl\Model\Content;
use Zrcms\ContentVersionControl\Model\Draft;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishDraft
{
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
