<?php

namespace Rcms\Core\Page\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CopyPage
{
    /**
     * @param Page        $page
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param int|null    $siteId
     * @param string|null $name
     * @param array       $properties
     * @param array       $blockInstances
     *
     * @return Page
     */
    public function __invoke(
        Page $page,
        string $createdByUserId,
        string $createdReason,
        int $siteId = null,
        string $name = null,
        array $properties = [],
        array $blockInstances = []
    ): Page;
}
