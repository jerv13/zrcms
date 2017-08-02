<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\ContentCore\Container\Model\PropertiesContainerVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesPageContainerVersion
    extends PropertiesPage
{
    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            PropertiesContainerVersion::ID => '',
            self::RENDER_DATA_GETTER => '',
            self::RENDERER => '',
            self::TITLE => '',
            self::DESCRIPTION => '',
            self::KEYWORDS => '',
            self::LAYOUT => '',
            self::PRE_RENDERED_HTML => '',
        ];
}
