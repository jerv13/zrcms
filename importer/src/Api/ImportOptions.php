<?php

namespace Zrcms\Importer\Api;

use Psr\Log\LoggerInterface;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportOptions
{
    const OPTION_LOGGER = 'logger';
    const OPTION_SLEEP = 'sleep';
    const OPTION_SKIP_DUPLICATES = 'skip-duplicates';

    const DEFAULT_SLEEP = 0;
    const DEFAULT_SKIP_DUPLICATES = true;

    protected $defaultSleep;
    protected $defaultSkipDuplicates;

    /**
     * @param int  $defaultSleep
     * @param bool $defaultSkipDuplicates
     */
    public function __construct(
        int $defaultSleep = self::DEFAULT_SLEEP,
        bool $defaultSkipDuplicates = self::DEFAULT_SKIP_DUPLICATES
    ) {
        $this->defaultSleep = $defaultSleep;
        $this->defaultSkipDuplicates = $defaultSkipDuplicates;
    }

    /**
     * @param array $options
     *
     * @return void
     */
    public function sleep(array $options)
    {
        $sleep = Property::getInt(
            $options,
            self::OPTION_SLEEP,
            $this->defaultSleep
        );

        if ($sleep) {
            usleep($sleep * 1000000);
        }
    }

    /**
     * @param array $options
     *
     * @return bool
     */
    public function skipDuplicates(array $options): bool
    {
        return Property::getBool(
            $options,
            self::OPTION_SKIP_DUPLICATES,
            $this->defaultSkipDuplicates
        );
    }

    /**
     * @param string $level
     * @param string $message
     * @param array  $options
     *
     * @return void
     */
    public function log(
        string $level,
        string $message,
        array $options
    ) {
        $logger = Property::get(
            $options,
            self::OPTION_LOGGER
        );

        if ($logger instanceof LoggerInterface) {
            $logger->log($level, $message);
            $this->sleep($options);
        }
    }
}
