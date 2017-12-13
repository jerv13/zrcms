<?php

namespace Zrcms\Logger\Service;

use Psr\Log\NullLogger;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class LoggerNoop extends NullLogger implements Logger
{

}
