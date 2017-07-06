<?php

namespace Rcms\Core\Page\Api;

use Rcms\Core\Page\Model\PageTemplate;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CreatePageTemplate
{
    /**
     * @param string $url
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $properties
     * @param array  $blockInstances
     * @param array  $options
     *
     * @return PageTemplate
     */
    public function __invoke(
        string $url,
        string $createdByUserId,
        string $createdReason,
        array $properties,
        array $blockInstances,
        array $options = []
    ): PageTemplate;
}
