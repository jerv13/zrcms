<?php

namespace Zrcms\CoreView\Api\ViewBuilder;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildViewDefaultPublishedAny extends BuildViewDefault implements BuildView
{
    const ATTRIBUTE_VIEW_PUBLISHED_ANY = 'zrcms-view-published-any';

    protected $published = null; // AKA Any
}
