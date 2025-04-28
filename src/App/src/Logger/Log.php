<?php

declare(strict_types=1);

namespace Api\App\Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

class Log extends AbstractLogger
{
    private string $logFile;
    private static string $defaultLogFile = 'log/app.log';

    public function __construct(string $logFile = 'app.log')
    {
        $this->logFile = $logFile;
    }

    public static function setDefaultLogFile(string $logFile): void
    {
        self::$defaultLogFile = $logFile;
    }

    public static function add($message, array $context = [], string $logFile = null, string $level = LogLevel::INFO): void
    {
        (new self($logFile ?? self::$defaultLogFile))->log($level, print_r($message, true), $context);
    }
    public static function trace(string $logFile = null, string $level = LogLevel::INFO): void
    {
        (new self($logFile ?? self::$defaultLogFile))->bt($logFile);
    }

    public function bt($filename = '', array $context = [], $level = LogLevel::INFO)
    {
        $backtrace = debug_backtrace();
        foreach ($backtrace as $call) {
            $location = $call['file'] ?? 'unknown file';
            $line = $call['line'] ?? 'unknown line';
            $function = $call['function'] ?? '';
            $class = $call['class'] ?? '';
            $type = $call['type'] ?? '';
            // Логирование
            self::add("{$location}:{$line} {$class}{$type}{$function}", $context, $filename, $level);
        }
    }

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        $logMessage = sprintf(
            "[%s] %s: %s %s\n",
            date('Y-m-d H:i:s'),
            strtoupper($level),
            $message,
            !empty($context) ? json_encode($context) : ''
        );

        file_put_contents($this->logFile, $logMessage, FILE_APPEND);
    }

    public function emergency(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    public function alert(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    public function critical(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    public function error(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    public function warning(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    public function notice(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    public function info(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    public function debug(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }
}
