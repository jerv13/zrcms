<?php

namespace Zrcms\Logger\Api;

use Psr\Log\LoggerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class LogBasic implements Log
{
    protected $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * @param string $level
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function __invoke(
        string $level,
        string $message,
        array $context = []
    ) {
        $this->logger->log(
            $level,
            $message,
            $context
        );
    }
}
