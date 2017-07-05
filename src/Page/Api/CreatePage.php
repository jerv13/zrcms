<?php

namespace Rcms\Core\Page\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CreatePage
{
    /**
     * @param int    $siteId
     * @param string $name
     * @param array  $properties
     * @param array  $blockInstances
     * @param string $createdByUserId
     * @param string $createdReason
     *
     * @return Page
     */
    public function __invoke(
        int $siteId,
        string $name,
        array $properties,
        array $blockInstances,
        string $createdByUserId,
        string $createdReason
    ): Page;
}
