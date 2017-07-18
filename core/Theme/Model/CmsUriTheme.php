<?php

namespace Zrcms\Core\Theme\Model;

use Zrcms\ContentResourceUri\Model\CmsUri;
use Zrcms\ContentResourceUri\Model\CmsUriBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CmsUriTheme extends CmsUriBasic implements CmsUri
{
    /**
     * @return string
     */
    public function getThemeName()
    {
        $path = $this->getPath();

        $parts = explode('/', $path);

        return $parts[0];
    }

    /**
     * @return string
     */
    public function getLayoutName()
    {
        $path = $this->getPath();

        $parts = explode('/', $path);

        if(!isset($parts[1])) {
            return LayoutDefault::NAME;
        }

        return $parts[1];
    }
}