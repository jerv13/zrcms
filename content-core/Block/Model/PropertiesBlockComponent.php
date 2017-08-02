<?php

namespace Zrcms\ContentCore\Block\Model;

use Zrcms\Content\Model\PropertiesComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesBlockComponent extends PropertiesComponent
{
    // required
    const DEFAULT_CONFIG = 'defaultConfig';
    const CACHEABLE = 'cache';

    // @todo const RENDER_DATA_GETTER = 'renderDataService';
    const RENDERER = 'renderer';
    const DATA_PROVIDER = 'data-provider';
    const FIELDS = 'fields';

    // client only
    const ICON = 'icon';
    const EDITOR = 'editor';
    const CATEGORY = 'category';
    const LABEL = 'label';
    const DESCRIPTION = 'description';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::NAME => '',
            self::LOCATION => '',
            self::DEFAULT_CONFIG => [],
            self::CACHEABLE => false,
            self::RENDERER => '',
            self::DATA_PROVIDER => '',
            self::FIELDS => [],
            self::ICON => '',
            self::CATEGORY => '',
            self::LABEL => '',
            self::DESCRIPTION => '',
        ];
}
