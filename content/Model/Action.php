<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Action
{
    const PUBLISH_CMS_RESOURCE = 'publish';
    const UNPUBLISH_CMS_RESOURCE = 'unpublish';
    const CONTENT_CHANGE = 'content-change';
}
