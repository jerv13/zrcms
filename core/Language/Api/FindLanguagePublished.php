<?php

namespace Zrcms\Core\Language\Api;

use Zrcms\Core\Language\Model\LanguagePublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLanguagePublished
{
    /**
     * @param          $id
     * @param null|int $lockMode
     * @param null|int $lockVersion
     * @param array $options
     *
     * @return LanguagePublished|null
     */
    public function __invoke(
        $id,
        $lockMode = null,
        $lockVersion = null,
        array $options = []
    );
}
