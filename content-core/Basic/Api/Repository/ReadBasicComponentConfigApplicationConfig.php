<?php

namespace Zrcms\ContentCore\Basic\Api\Repository;

use Zrcms\Content\Api\Repository\ReadComponentConfig;
use Zrcms\Content\Api\Repository\ReadComponentConfigApplicationConfigAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadBasicComponentConfigApplicationConfig
    extends ReadComponentConfigApplicationConfigAbstract
    implements ReadComponentConfig
{
    const SERVICE_ALIAS = 'app-config';
}
