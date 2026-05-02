<?php

namespace Kernel\Application\Session;

trait FlashTrait
{
    /**
     * @var array The array to store flash messages.
     */
    protected array $flash = [];

    /**
     * Gets a flash message by key.
     *
     * This method retrieves a flash message and removes it from the
     * session/flash storage to ensure it's only shown once.
     *
     * @param  string|null  $key  The key of the flash message to retrieve. If null, all flash messages are returned.
     * @return mixed The flash message associated with the given key or all flash messages.
     */
    public function getFlash(?string $key = null): mixed
    {
        if ($key === null) {
            $flash = $this->flash ?? [];
            $this->flash = [];  // Clears all flash messages after retrieval

            return $flash;
        }

        $value = $this->flash[$key] ?? null;
        unset($this->flash[$key]);  // Removes the retrieved flash message

        return $value;
    }

    /**
     * Sets a flash message.
     *
     * This method stores a one-time flash message that will be available
     * on the next request (typically after a redirect).
     *
     * @param  string  $key  The key to identify the flash message.
     * @param  mixed  $value  The value (content) of the flash message.
     */
    public function setFlash(string $key, mixed $value): void
    {
        $this->flash[$key] = $value;
        $this->saveDataToFile();  // Optionally save the flash message to a persistent storage (e.g., file)
    }

    /**
     * Clears all flash messages.
     *
     * This method clears all flash messages from storage.
     */
    private function clearFlash(): void
    {
        $this->flash = [];
    }
}
