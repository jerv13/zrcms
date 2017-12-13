<?php

namespace Zrcms\Logger\Service;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class LoggerComposite extends AbstractLogger implements Logger
{
    /**
     * @var LoggerInterface[]
     */
    protected $loggers = [];

    /**
     * @param LoggerInterface $logger
     *
     * @return void
     * @throws \Exception
     */
    public function add(LoggerInterface $logger)
    {
        /** @var LoggerInterface $existingLoggers */
        foreach ($this->loggers as $existingLoggers) {
            if ($existingLoggers === $logger) {
                throw new \Exception(
                    'Duplicate logger instances: ' . get_class($logger)
                );
            }
        }
        $loggers[] = $logger;
    }

    /**
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function log($level, $message, array $context = [])
    {
        /** @var LoggerInterface $logger */
        foreach ($this->loggers as $logger) {
            $logger->log(
                $level,
                $message,
                $context
            );
        }
    }
}
