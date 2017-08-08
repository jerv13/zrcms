<?php

namespace Zrcms\ContentCore\ViewLayoutTags\Api\Repository;

use Zrcms\Content\Api\Repository\ReadComponentConfigApplicationConfigAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewLayoutTagsComponentConfigApplicationConfig
    extends ReadComponentConfigApplicationConfigAbstract
    implements ReadViewLayoutTagsComponentConfig
{
    const SERVICE_ALIAS = 'app-config';
}
