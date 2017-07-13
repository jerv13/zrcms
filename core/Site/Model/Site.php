<?php

namespace Zrcms\Core\Site\Model;

use Zrcms\ContentVersionControl\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Site extends Content
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * <identifier>
     *
     * @return string
     */
    public function getHost(): string;

    /**
     * @return string
     */
    public function getSourceHost(): string;

    /**
     * @return string
     */
    public function getTheme(): string;

    /**
     * @return string
     */
    public function getLocale(): string;
}
