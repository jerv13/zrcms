<?php

namespace Zrcms\ContentVersionControlDoctrine\Api\Action;

use Zrcms\ContentVersionControl\Model\Content;
use Zrcms\ContentVersionControl\Model\History;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class UnpublishContent implements \Zrcms\ContentVersionControl\Api\Action\UnpublishContent
{
    /**
     * @param Content $content
     * @param string  $modifiedByUserId
     * @param string  $modifiedReason
     * @param array   $options
     *
     * @return History
     */
    public function __invoke(
        Content $content,
        string $modifiedByUserId,
        string $modifiedReason,
        array $options = []
    ): History
    {

    }
}
