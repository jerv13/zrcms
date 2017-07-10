<?php

namespace Zrcms\Core\Page\Api;

use Zrcms\Core\Page\Model\PageTemplate;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CreatePageTemplate
{
    /**
     * @param string $uri
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $properties
     * @param array  $options
     *
     * @return PageTemplate
     */
    public function __invoke(
        string $uri,
        string $createdByUserId,
        string $createdReason,
        array $properties,
        array $options = []
    ): PageTemplate;
}
