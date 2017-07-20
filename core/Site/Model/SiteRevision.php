<?php

namespace Zrcms\Core\Site\Model;

use Zrcms\Content\Model\ContentRevision;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface SiteRevision extends ContentRevision
{
    /**
     * @return string
     */
    public function getThemeName(): string;

    /**
     * @return string
     */
    public function getLocale(): string;
}
