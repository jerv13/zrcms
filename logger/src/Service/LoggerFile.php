<?php

namespace Zrcms\Logger\Service;

use Psr\Log\AbstractLogger;
use Reliv\Json\Json;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class LoggerFile extends AbstractLogger implements Logger
{
    protected $logDirectory;

    /**
     * @param string $logDirectory
     */
    public function __construct(
        string $logDirectory
    ) {
        $this->logDirectory = $logDirectory;
    }

    /**
     * @param string $level
     * @param string $message
     * @param array  $context
     *
     * @return null|void
     */
    public function log($level, $message, array $context = [])
    {
        $timezone = new \DateTimeZone('UTC');

        $dateTime = new \DateTime(
            'now',
            $timezone
        );

        $logEntry = $this->buildLogEntry($dateTime, $level, $message, $context);

        //@todo Might need to create directory first

        $filePath = $this->logDirectory . '/' . $dateTime->format('Y-m-d') . '.log';

        $this->writeFile(
            $filePath,
            $logEntry
        );
    }

    /**
     * @param \DateTime $dateTime
     * @param string    $level
     * @param string    $message
     * @param array     $context
     *
     * @return string
     */
    protected function buildLogEntry(\DateTime $dateTime, $level, $message, array $context = [])
    {
        $logEntryArray = [];

        $logEntryArray['date-time'] = $dateTime->format(\DateTime::ISO8601);
        $logEntryArray['level'] = $level;
        $logEntryArray['message'] = $message;
        $logEntryArray['context'] = $context;

        return Json::encode($logEntryArray, 0, 5);
    }

    /**
     * @param $filePath
     * @param $contents
     *
     * @return void
     */
    protected function writeFile($filePath, $contents)
    {
        if (!file_exists($filePath)) {
            $this->createDirectory($filePath);
        }
        $contents = $contents . "\n";
        file_put_contents(
            "$filePath",
            $contents,
            FILE_APPEND
        );
    }

    /**
     * @param $filePath
     *
     * @return void
     */
    protected function createDirectory($filePath)
    {
        $parts = explode('/', $filePath);
        $file = array_pop($parts);
        $dir = '';
        foreach ($parts as $part) {
            if (!is_dir($dir .= "/$part")) {
                mkdir($dir);
            }
        }
    }
}
