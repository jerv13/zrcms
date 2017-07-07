<?php

namespace Zrcms\Language\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLanguagesPublishedBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null|int   $limit
     * @param null|int   $offset
     * @param array      $options
     *
     * @return array [LanguagePublished]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ):array ;
}
