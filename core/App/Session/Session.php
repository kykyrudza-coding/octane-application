<?php

namespace Kernel\Application\Session;

use AllowDynamicProperties;
use RuntimeException;

/**
 * Class Session
 *
 * This class handles session management, extending the `FileManager` to provide
 * additional functionality such as session data management, user authentication,
 * and CSRF protection. It manages session initialization, session file storage,
 * and data retrieval, ensuring the session persists between requests.
 */
#[AllowDynamicProperties]
class Session extends FileManager
{
    use CSRFTrait, FlashTrait, OldTrait, UserTrait, ValidationErrorsTrait;

    /**
     * @var string The unique identifier for the current session.
     */
    protected string $sessionId;

    /**
     * @var int The timestamp when the session started.
     */
    protected int $startTime;

    /**
     * @var int The timestamp when the session will expire.
     */
    protected int $endTime;

    /**
     * @var array The flash data that is stored for one request cycle.
     */
    protected array $flash = [];

    /**
     * @var array The old input data from previous requests.
     */
    protected array $old = [];

    /**
     * @var array The validation errors that occurred during the request.
     */
    protected array $validationErrors = [];

    /**
     * @var array The user data associated with the session.
     */
    protected array $user = [];

    /**
     * @var string The CSRF token used to protect against cross-site request forgery.
     */
    protected string $csrfToken = '';

    /**
     * @var bool The login status of the user.
     */
    protected bool $isLogin = false;

    /**
     * Session constructor.
     *
     * Initializes the session by starting it and setting up necessary session
     * file paths. The session ID is generated, and the session file is created
     * if it doesn't exist.
     *
     * @param  string  $sessionDir  The directory where session files are stored.
     *
     * @throws RuntimeException If session start or file creation fails.
     */
    public function __construct(string $sessionDir = APP_ROOT.'/tmp/sessions')
    {
        parent::__construct($sessionDir);

        if (session_status() === PHP_SESSION_NONE) {
            if (! session_start()) {
                throw new RuntimeException('Failed to start the session.');
            }
        }

        $this->sessionId = session_id();

        $this->sessionFile = $this->sessionDir.'/sess_'.$this->sessionId;

        $this->startSession();
    }

    /**
     * Starts the session and initializes necessary session data.
     *
     * This method checks if the session is already started, creates the session
     * file if it doesn't exist, and loads the session data from the file.
     *
     * @return self The current instance of the `Session` class.
     *
     * @throws RuntimeException If session start or session file creation fails.
     */
    public function startSession(): self
    {
        if (session_status() === PHP_SESSION_NONE) {
            if (! session_start()) {
                throw new RuntimeException('Failed to start the session.');
            }
        }

        if (! file_exists($this->sessionFile)) {
            $fileCreated = touch($this->sessionFile);
            if (! $fileCreated) {
                throw new RuntimeException("Failed to create session file: {$this->sessionFile}");
            }
        }

        $this->startTime = time();
        $this->endTime = $this->startTime + (int) ini_get('session.gc_maxlifetime');

        $this->loadDataFromFile();
        $this->saveDataToFile();

        return $this;
    }

    /**
     * Destroys the current session and deletes the session file.
     *
     * This method removes the session file from the filesystem and clears
     * the session data. After the session is destroyed, the data is saved to
     * the session file to ensure any final updates are persisted.
     */
    public function destroySession(): void
    {
        if (file_exists($this->sessionFile)) {
            unlink($this->sessionFile);
        }

        $this->clearSessionData();
        $this->saveDataToFile();
    }

    /**
     * Clears the session data.
     *
     * This method clears all session-related data, including flash data, old
     * input, validation errors, and user information.
     */
    private function clearSessionData(): void
    {
        $this->clearFlash();
        $this->clearOldData();
        $this->clearValidationErrors();
        $this->clearUser();
    }
}
