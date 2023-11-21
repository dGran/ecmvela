<?php

declare(strict_types=1);

namespace App\Utils;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Level;
use Monolog\Logger as MonologLogger;
use Psr\Log\LoggerInterface;

/**
 * Class Logger
 *
 * @method emergency(string $message, mixed $data = [])
 * @method alert(string $message, mixed $data = [])
 * @method critical(string $message, mixed $data = [])
 * @method error(string $message, mixed $data = [])
 * @method warning(string $message, mixed $data = [])
 * @method notice(string $message, mixed $data = [])
 * @method info(string $message, mixed $data = [])
 * @method debug(string $message, mixed $data = [])
 */
class Logger
{
    public const MAX_FILES = 7;

    private static ?Logger $loggerInstance = null;

    private LoggerInterface $appLogger;

    private function __construct()
    {
        $loggerName = 'app';
        $loggingFile = \dirname(__DIR__).'var/log/app_'.date('YmdH').'log';;

        $loggerHandler = new RotatingFileHandler($loggingFile, self::MAX_FILES, Level::Debug);
        $this->appLogger = new MonologLogger($loggerName);
        $this->appLogger->pushHandler($loggerHandler);
    }

    public static function getInstance(): Logger
    {
        if (!self::$loggerInstance) {
            self::$loggerInstance = new Logger();
        }

        return self::$loggerInstance;
    }

    public function __call($levelName, $arguments)
    {
        $argumentsCount = \count($arguments);

        if (0 === $argumentsCount) {
            throw new \InvalidArgumentException('Logger needs at least a message.');
        }

        $message = $arguments[0];
        $data = [];

        if (2 === $argumentsCount) {
            $data = $arguments[1];

            if (!\is_array($data)) {
                $data = [$data];
            }
        }

        return $this->appLogger->{$levelName}($message, $data);
    }

    public function getLogger(): LoggerInterface
    {
        return $this->appLogger;
    }
}
