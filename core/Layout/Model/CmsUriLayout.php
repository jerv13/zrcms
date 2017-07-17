<?php

namespace Zrcms\Core\Layout\Model;

use Zrcms\ContentResourceUri\Model\CmsUri;
use Zrcms\ContentResourceUri\Model\CmsUriBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CmsUriLayout extends CmsUriBasic implements CmsUri
{
    /**
     * @return string
     */
    public function getThemeName()
    {
        $path = $this->getPath();

        $parts = explode('/', $path);

        return $path[0];
    }

    /**
     * @return string
     */
    public function getLayoutName()
    {
        $path = $this->getPath();

        $parts = explode('/', $path);

        return $path[1];
    }
}
