<?php

namespace Kernel\Console;

use Kernel\Console\Commands\CreateSQLiteDatabaseCommand;
use Kernel\Console\Commands\LinkStorageCommand;
use Kernel\Console\Commands\StartServer;
use Symfony\Component\Console\Application as SymfonyConsoleApp;

/**
 * Console application class for managing command-line tasks.
 *
 * This class extends Symfony's Console Application and registers various
 * custom commands such as starting the server, creating the SQLite database,
 * and linking storage.
 */
class App extends SymfonyConsoleApp
{
    /**
     * Constructor to initialize the console application.
     *
     * Sets the application name and version, and registers the custom commands.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct('Octane Console Assistant', '1.0.0');

        // Register the custom commands
        $this->add(new StartServer);
        $this->add(new CreateSQLiteDatabaseCommand);
        $this->add(new LinkStorageCommand);
    }
}
