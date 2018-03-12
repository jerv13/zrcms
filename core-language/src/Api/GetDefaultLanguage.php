<?php

namespace Zrcms\CoreLanguage\Api;

use Zrcms\CoreLanguage\Model\Language;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetDefaultLanguage
{
    /**
     * @return Language
     * @throws \Exception
     */
    public function __invoke(): Language;
}
