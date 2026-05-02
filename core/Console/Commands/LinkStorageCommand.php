<?php

namespace Kernel\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Command for creating a symbolic link from the storage directory to the public directory.
 *
 * This command creates a symbolic link from the storage directory to the public directory, allowing
 * the public web server to access files stored in the storage directory. If symbolic links are not
 * supported, the command will attempt to copy the storage directory to the public directory.
 */
class LinkStorageCommand extends Command
{
    /**
     * The name of the command.
     */
    protected static string $defaultName = 'storage:link';

    /**
     * LinkStorageCommand constructor.
     *
     * Initializes the command with the default name.
     */
    public function __construct()
    {
        parent::__construct(self::$defaultName);
    }

    /**
     * Configures the command options and description.
     *
     * Sets the description and help text for the command.
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Links the storage directory to the public directory')
            ->setHelp('This command creates a symbolic link or copies the storage directory to the public directory if symbolic links are not supported.');
    }

    /**
     * Executes the command to create the symbolic link.
     *
     * This method checks if the storage directory exists, removes any existing symbolic link
     * at the target path, and then attempts to create a new symbolic link.
     * If symbolic link creation fails, the command will provide an error message.
     *
     * @param  InputInterface  $input  The input interface.
     * @param  OutputInterface  $output  The output interface.
     * @return int Command exit status.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filesystem = new Filesystem;
        $storageDir = APP_ROOT.'/storage';
        $publicDir = APP_ROOT.'/public';
        $linkPath = $publicDir.'/storage';

        if (! $filesystem->exists($storageDir)) {
            $output->writeln('<error>Storage directory does not exist.</error>');

            return Command::FAILURE;
        }

        if ($filesystem->exists($linkPath)) {
            $filesystem->remove($linkPath);
        }

        try {
            $filesystem->symlink($storageDir, $linkPath);

            if (! is_link($linkPath)) {
                throw new \RuntimeException('Symbolic link creation failed.');
            }

            $output->writeln('<info>Symbolic link created successfully: '.$linkPath.'</info>');
        } catch (\Exception $e) {
            $output->writeln('<comment>Failed to create symbolic link: '.$e->getMessage().'</comment>');
        }

        return Command::SUCCESS;
    }
}
