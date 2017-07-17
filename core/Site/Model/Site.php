<?php

namespace Zrcms\Core\Site\Model;

use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Site extends Content
{
    /**
     * <identifier>
     *
     * @return string
     */
    public function getHost(): string;

    /**
     * @return string
     */
    public function getTheme(): string;

    /**
     * @return string
     */
    public function getLocale(): string;
}
