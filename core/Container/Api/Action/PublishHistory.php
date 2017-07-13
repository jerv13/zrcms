<?php

namespace Zrcms\Core\Container\Api\Action;

use Zrcms\ContentVersionControl\Model\Content;
use Zrcms\ContentVersionControl\Model\History;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishHistory
{
    /**
     * @param History $history
     * @param string  $modifiedByUserId
     * @param string  $modifiedReason
     * @param array   $options
     *
     * @return Content
     */
    public function __invoke(
        History $history,
        string $modifiedByUserId,
        string $modifiedReason,
        array $options = []
    ): Content;
}
