<?php

namespace Zrcms\Importer\Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CliLogger extends AbstractLogger implements LoggerInterface
{
    protected $output;

    public function __construct(
        OutputInterface $output
    ) {
        $this->output = $output;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        $spaceCount = 10 - strlen($level);

        $space = str_repeat(' ', $spaceCount);

        $this->output->writeln($level . $space . ': ' . $message);
    }
}
