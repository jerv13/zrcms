<?php

namespace Rcms\Core\Language\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindCountriesPublishedBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null|int   $limit
     * @param null|int   $offset
     * @param array      $options
     *
     * @return array [CountryPublished]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    );
}
