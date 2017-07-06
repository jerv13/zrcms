<?php

namespace Rcms\Core\Language\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLanguagesPublishedBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     *
     * @return array [LanguagePublished]
     */
    public function __invoke(array $criteria, array $orderBy = null, $limit = null, $offset = null);
}
