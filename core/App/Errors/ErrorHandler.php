<?php

namespace Kernel\Application\Errors;

use Throwable;

class ErrorHandler
{
    private const  FATAL_TYPES = [
        E_ERROR,
        E_PARSE,
        E_CORE_ERROR,
        E_COMPILE_ERROR,
        E_USER_ERROR,
    ];

    private const  CODE_CONTEXT_LINES = 6;

    private const  ERROR_VIEW = __DIR__ . '/errors/error.php';

    private static bool $rendered = false;

    public static function register(): void
    {
        set_exception_handler(self::handleException(...));
        set_error_handler(self::handleError(...));
        register_shutdown_function(self::handleShutdown(...));
    }

    public static function handleException(Throwable $exception): void
    {
        self::render(
            message: $exception->getMessage(),
            code:    $exception->getCode(),
            file:    $exception->getFile(),
            line:    $exception->getLine(),
            trace:   $exception->getTraceAsString(),
            type:    $exception::class,
        );
    }

    public static function handleError(int $errno, string $errstr, string $errfile, int $errline): bool
    {
        if (! (error_reporting() & $errno)) {
            return false;
        }

        self::render(
            message: $errstr,
            code:    $errno,
            file:    $errfile,
            line:    $errline,
            trace:   self::formatTrace(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)),
            type:    'PHP Error',
        );

        return true;
    }

    public static function handleShutdown(): void
    {
        if (self::$rendered) {
            return;
        }

        $error = error_get_last();

        if ($error === null || ! in_array($error['type'], self::FATAL_TYPES, true)) {
            return;
        }

        self::render(
            message: $error['message'],
            code:    $error['type'],
            file:    $error['file'] ?? 'Unknown file',
            line:    $error['line'] ?? 0,
            trace:   '',
            type:    'Fatal Error',
        );
    }

    private static function render(
        string $message,
        int    $code,
        string $file,
        int    $line,
        string $trace,
        string $type,
    ): void {
        if (self::$rendered) {
            exit;
        }

        self::$rendered = true;
        self::cleanOutputBuffers();

        http_response_code(500);

        error_log(sprintf('%s [%d]: %s in %s on line %d', $type, $code, $message, $file, $line));

        $debug          = self::isDebug();
        $codeContext    = self::buildCodeContext($file, $line);
        $requestSummary = self::requestSummary();

        extract([
            'debug'          => $debug,
            'errorType'      => $type,
            'errorMessage'   => $message,
            'errorCode'      => $code,
            'errorFile'      => $file,
            'errorLine'      => $line,
            'errorTrace'     => $trace,
            'codeContext'    => $codeContext,
            'requestSummary' => $requestSummary,
        ], EXTR_SKIP);

        include self::ERROR_VIEW;

        exit;
    }

    private static function isDebug(): bool
    {
        $value = $_ENV['APP_DEBUG'] ?? getenv('APP_DEBUG');

        if ($value === false || $value === '') {
            return false;
        }

        return filter_var($value, FILTER_VALIDATE_BOOL);
    }

    private static function cleanOutputBuffers(): void
    {
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
    }

    private static function buildCodeContext(string $file, int $line): array
    {
        if (! is_file($file) || ! is_readable($file)) {
            return [];
        }

        $lines = file($file, FILE_IGNORE_NEW_LINES);

        if ($lines === false) {
            return [];
        }

        $total   = count($lines);
        $start   = max(1, $line - self::CODE_CONTEXT_LINES);
        $end     = min($total, $line + self::CODE_CONTEXT_LINES);
        $context = [];

        for ($current = $start; $current <= $end; $current++) {
            $context[] = [
                'number'    => $current,
                'content'   => $lines[$current - 1] ?? '',
                'highlight' => $current === $line,
            ];
        }

        return $context;
    }

    private static function requestSummary(): array
    {
        return [
            'method' => $_SERVER['REQUEST_METHOD'] ?? 'CLI',
            'uri'    => $_SERVER['REQUEST_URI']     ?? '',
            'host'   => $_SERVER['HTTP_HOST']       ?? '',
            'ip'     => $_SERVER['REMOTE_ADDR']     ?? '',
        ];
    }

    private static function formatTrace(array $trace): string
    {
        $lines = [];

        foreach ($trace as $index => $frame) {
            $file     = $frame['file']     ?? '[internal]';
            $line     = $frame['line']     ?? 0;
            $function = ($frame['class']   ?? '')
                . ($frame['type']    ?? '')
                . ($frame['function'] ?? '');

            $lines[] = sprintf('#%d %s:%d %s()', $index, $file, $line, $function);
        }

        return implode(PHP_EOL, $lines);
    }
}