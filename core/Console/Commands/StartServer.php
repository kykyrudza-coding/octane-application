<?php

namespace Kernel\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command for starting a local development server.
 *
 * This command uses PHP's built-in server to start a local server for development purposes.
 */
class StartServer extends Command
{
    /**
     * The name of the command.
     */
    protected static $defaultName = 'server:start';

    /**
     * StartServer constructor.
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
     * Sets the description, help text, and options for the command:
     * - host: Specifies the server host (default: '127.0.0.1').
     * - port: Specifies the server port (default: '8000').
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setDescription('Start a local development server')
            ->setHelp('This command starts a PHP built-in server for development')
            ->addOption(
                'host',
                null,
                InputOption::VALUE_OPTIONAL,
                'Host for the server',
                '127.0.0.1'
            )
            ->addOption(
                'port',
                null,
                InputOption::VALUE_OPTIONAL,
                'Port for the server',
                '8000'
            );
    }

    /**
     * Executes the command to start the server.
     *
     * This method retrieves the host and port options, and then starts
     * the PHP built-in server using the specified host and port.
     *
     * @param  InputInterface  $input  The input interface.
     * @param  OutputInterface  $output  The output interface.
     * @return int Command exit status.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $host = $input->getOption('host');
        $port = $input->getOption('port');

        $output->writeln("Starting server at <info>http://$host:$port</info>");
        $output->writeln('<comment>Press Ctrl+C to stop the server.</comment>');

        $command = sprintf('php -S %s:%s -t public', escapeshellarg($host), escapeshellarg($port));
        passthru($command);

        return Command::SUCCESS;
    }
}
