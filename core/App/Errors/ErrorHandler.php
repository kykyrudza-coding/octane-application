<?php

namespace Kernel\Application\Errors;

/**
 * Class ErrorHandler
 *
 * A custom error handler that captures and renders detailed information about errors and exceptions.
 * It provides methods for handling exceptions, errors, and shutdown scenarios, and logging them for debugging.
 * Additionally, it renders an error page with the captured details.
 */
class ErrorHandler
{
    /**
     * @var string The error message.
     */
    private string $errorMessage;

    /**
     * @var int The error code.
     */
    private int $errorCode;

    /**
     * @var string The file where the error occurred.
     */
    private string $errorFile;

    /**
     * @var int The line where the error occurred.
     */
    private int $errorLine;

    /**
     * ErrorHandler constructor.
     *
     * Initializes the error handler with the provided error details and renders the error page.
     *
     * @param  string  $errorMessage  The error message.
     * @param  int  $errorCode  The error code.
     * @param  string  $errorFile  The file where the error occurred.
     * @param  int  $errorLine  The line where the error occurred.
     */
    public function __construct(
        string $errorMessage,
        int $errorCode,
        string $errorFile,
        int $errorLine
    ) {
        $this->errorMessage = $errorMessage;
        $this->errorCode = $errorCode;
        $this->errorFile = $errorFile;
        $this->errorLine = $errorLine;

        $this->renderError();
    }

    /**
     * Handles uncaught exceptions.
     *
     * Captures the exception details (message, code, file, line) and logs them,
     * then renders the error using the ErrorHandler class.
     *
     * @param  \Throwable  $exception  The uncaught exception to handle.
     */
    public static function handleException(\Throwable $exception): void
    {
        $errorFile = $exception->getFile();
        $errorLine = $exception->getLine();

        error_log('Exception occurred in file: '.$errorFile.' on line: '.$errorLine);

        new self($exception->getMessage(), $exception->getCode(), $errorFile, $errorLine);
    }

    /**
     * Handles PHP errors.
     *
     * Captures error details (errno, message, file, line), logs them,
     * and renders the error using the ErrorHandler class.
     *
     * @param  int  $errno  The error number.
     * @param  string  $errstr  The error message.
     * @param  string  $errfile  The file where the error occurred.
     * @param  int  $errline  The line where the error occurred.
     */
    public static function handleError(int $errno, string $errstr, string $errfile, int $errline): void
    {
        ob_clean();

        $backtrace = debug_backtrace();
        $errorFile = $backtrace[1]['file'] ?? 'Unknown file';
        $errorLine = $backtrace[1]['line'] ?? 0;

        error_log("Error occurred in file: $errorFile on line: $errorLine");

        $message = "Error: [$errno] $errstr";
        new self($message, $errno, $errfile, $errline);
    }

    /**
     * Handles fatal errors during script shutdown.
     *
     * Captures the last error that caused the shutdown and renders it using the ErrorHandler class.
     */
    public static function handleShutdown(): void
    {
        $error = error_get_last();
        if ($error !== null) {
            $message = "Fatal Error: [{$error['type']}] {$error['message']}";
            $errorFile = $error['file'] ?? 'Unknown file';
            $errorLine = $error['line'] ?? 0;

            error_log('Shutdown error occurred in file: '.$errorFile.' on line: '.$errorLine);

            $message .= " in $errorFile on line $errorLine";
            new self($message, $error['type'], $errorFile, $errorLine);
        }
    }

    /**
     * Renders the error page.
     *
     * This method uses the provided error details (message, file, line) to render a user-friendly error page.
     * It includes an external error view file for displaying the error.
     */
    private function renderError(): void
    {
        extract([
            'errorMessage' => $this->errorMessage,
            'errorFile' => $this->errorFile,
            'errorLine' => $this->errorLine,
        ]);

        include __DIR__.'/errors/error.php';

        exit();
    }
}
