<?php

namespace Zrcms\ContentCore\Basic\Api\Component;

use Zrcms\Content\Api\Component\ReadComponentConfig;
use Zrcms\Content\Api\Component\ReadComponentConfigApplicationConfigAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadBasicComponentConfigApplicationConfig
    extends ReadComponentConfigApplicationConfigAbstract
    implements ReadComponentConfig
{
    const SERVICE_ALIAS = 'app-config';
}
