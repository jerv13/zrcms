<?php

namespace Rcms\Core\Language\Api;

use Rcms\Core\Language\Model\LanguagePublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLanguagePublished
{
    /**
     * @param          $id
     * @param null|int $lockMode
     * @param null|int $lockVersion
     *
     * @return LanguagePublished|null
     */
    public function __invoke($id, $lockMode = null, $lockVersion = null);
}
