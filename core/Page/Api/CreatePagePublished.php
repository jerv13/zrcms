<?php

namespace Zrcms\Core\Page\Api;

use Zrcms\Core\Page\Model\PageDraft;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CreatePagePublished
{
    /**
     * @param string $uri
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $properties
     * @param array  $blockInstances
     * @param array  $options
     *
     * @return PageDraft
     */
    public function __invoke(
        string $uri,
        string $createdByUserId,
        string $createdReason,
        array $properties,
        array $blockInstances,
        array $options = []
    ): PageDraft;
}
