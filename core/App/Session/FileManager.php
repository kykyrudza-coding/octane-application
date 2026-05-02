<?php

namespace Kernel\Application\Session;

use AllowDynamicProperties;
use RuntimeException;

/**
 * Abstract class FileManager
 *
 * This abstract class manages session data storage and retrieval using files.
 * It provides functionality to load session data from a file and save session
 * data to a file. The session data is stored in JSON format to allow persistence
 * across requests.
 */
#[AllowDynamicProperties]
abstract class FileManager
{
    /**
     * @var string The session file name. This will be set dynamically based on session ID.
     */
    protected string $sessionFile = '';

    /**
     * @var string The directory where session files are stored.
     */
    protected string $sessionDir;

    /**
     * FileManager constructor.
     *
     * This constructor initializes the session directory. By default, the session
     * files are stored in the 'tmp/sessions' directory under the application's root.
     *
     * @param  string  $sessionDir  The directory where session files will be stored.
     */
    public function __construct(string $sessionDir = APP_ROOT.'/tmp/sessions')
    {
        $this->sessionDir = $sessionDir;
    }

    /**
     * Loads session data from the file system.
     *
     * This method loads the session data from a file located in the session directory.
     * If the session file exists and contains valid data, it populates the flash data,
     * old input, validation errors, user information, and login status.
     */
    protected function loadDataFromFile(): void
    {
        $filePath = $this->sessionDir.'/sess_'.$this->sessionId;
        if (file_exists($filePath)) {
            $sessionData = json_decode(file_get_contents($filePath), true);
            if ($sessionData) {
                $this->flash = $sessionData['flash'] ?? [];
                $this->old = $sessionData['old'] ?? [];
                $this->validationErrors = $sessionData['validationErrors'] ?? [];
                $this->user = $sessionData['user'] ?? [];
                $this->isLogin = $sessionData['isLogin'] ?? false;
            }
        }
    }

    /**
     * Saves session data to the file system.
     *
     * This method saves the session data to a file in the session directory. The
     * data is encoded in JSON format and written to the session file.
     *
     * @throws RuntimeException If saving session data to the file fails.
     */
    protected function saveDataToFile(): void
    {
        $sessionData = [
            'flash' => $this->flash,
            'old' => $this->old,
            'validationErrors' => $this->validationErrors,
            'user' => $this->user,
            'isLogin' => $this->isLogin,
        ];

        $filePath = $this->sessionDir.'/sess_'.$this->sessionId;

        if (file_put_contents($filePath, json_encode($sessionData, JSON_PRETTY_PRINT)) === false) {
            throw new RuntimeException("Failed to save session data to file: $filePath");
        }
    }
}
