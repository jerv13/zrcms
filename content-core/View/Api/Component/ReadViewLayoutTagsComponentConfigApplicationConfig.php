<?php

namespace Zrcms\ContentCore\View\Api\Component;

use Zrcms\Content\Api\Component\ReadComponentConfigApplicationConfigAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewLayoutTagsComponentConfigApplicationConfig
    extends ReadComponentConfigApplicationConfigAbstract
    implements ReadViewLayoutTagsComponentConfig
{
    const SERVICE_ALIAS = 'app-config';
}
