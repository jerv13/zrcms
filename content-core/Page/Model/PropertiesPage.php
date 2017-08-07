<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\ContentCore\Container\Model\PropertiesContainer;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesPage extends PropertiesContainer
{
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const KEYWORDS = 'keywords';
    const LAYOUT = 'layout';
    const PRE_RENDERED_HTML = 'html';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::ID => '',
            self::RENDER_TAGS_GETTER => '',
            self::RENDERER => '',
            self::TITLE => '',
            self::DESCRIPTION => '',
            self::KEYWORDS => '',
            self::LAYOUT => '',
            self::PRE_RENDERED_HTML => '',
        ];
}
