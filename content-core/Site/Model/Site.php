<?php

namespace Zrcms\ContentCore\Site\Model;

use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Site extends Content
{
    /**
     * @return string
     */
    public function getThemeName(): string;

    /**
     * @return string
     */
    public function getLocale(): string;

    /**
     * @param string     $httpStatus
     * @param mixed|null $default
     *
     * @return array
     */
    public function findStatusPage(string $httpStatus, $default = null);
}
