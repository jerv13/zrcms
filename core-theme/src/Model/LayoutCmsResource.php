<?php

namespace Zrcms\CoreTheme\Model;

use Zrcms\Core\Model\CmsResource;
use Zrcms\Core\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface LayoutCmsResource extends CmsResource
{
    /**
     * @return LayoutVersion|ContentVersion
     */
    public function getContentVersion();

    /**
     * @return string
     */
    public function getThemeName(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getHtml(): string;
}
