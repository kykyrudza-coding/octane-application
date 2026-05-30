<?php

namespace Kernel\Console\Commands;

use PDO;
use PDOException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command for creating an empty SQLite database at a specified path.
 *
 * This command creates a new SQLite database at the specified path, typically used during
 * application setup. If the database directory doesn't exist, it will be created.
 */
class CreateSQLiteDatabaseCommand extends Command
{
    /**
     * The name of the command.
     */
    protected static string $defaultName = 'app:database';

    /**
     * CreateSQLiteDatabaseCommand constructor.
     *
     * Initializes the command with its default name.
     */
    public function __construct()
    {
        parent::__construct(self::$defaultName);
    }

    /**
     * Configures the command's options and description.
     *
     * Sets the description for the command, which describes its purpose.
     */
    protected function configure(): void
    {
        $this->setDescription('Creates a new empty SQLite database at the specified path.');
    }

    /**
     * Executes the command to create a new SQLite database.
     *
     * This method checks if the directory for the database exists. If not, it creates it.
     * Then it attempts to create an empty SQLite database at the specified path. If successful,
     * a success message is displayed. If an error occurs during database creation, an error message is shown.
     *
     * @param  InputInterface  $input  The input interface.
     * @param  OutputInterface  $output  The output interface.
     * @return int Command exit status (success or failure).
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dbPath = DATABASE_PATH.'/database.sqlite';

        // Ensure the database directory exists
        if (! file_exists(dirname($dbPath))) {
            mkdir(dirname($dbPath), 0777, true);
        }

        try {
            // Attempt to create the SQLite database
            $pdo = new PDO("sqlite:$dbPath");

            // Set error handling for PDO
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $output->writeln("<info>SQLite database created successfully at: $dbPath</info>");

            return Command::SUCCESS;
        } catch (PDOException $e) {
            // Handle errors during the database creation process
            $output->writeln('<error>Failed to create SQLite database: '.$e->getMessage().'</error>');

            return Command::FAILURE;
        }
    }
}
