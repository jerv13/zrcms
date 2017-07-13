<?php

namespace Zrcms\ContentVersionControlDoctrine\Api\Action;

use Zrcms\ContentVersionControl\Model\Draft;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class CreateDraft implements \Zrcms\ContentVersionControl\Api\Action\CreateDraft
{
    /**
     * @param string $uri
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $properties
     * @param array  $options
     *
     * @return Draft
     */
    public function __invoke(
        string $uri,
        string $createdByUserId,
        string $createdReason,
        array $properties,
        array $options = []
    ): Draft
    {

    }
}
