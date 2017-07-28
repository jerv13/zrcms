<?php

namespace Zrcms\Importer\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zrcms\Importer\Api\Import;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CommandImport extends Command
{
    /**
     * @var Import
     */
    protected $import;

    /**
     * @param Import $import
     */
    public function __construct(
        Import $import
    ) {
        $this->import = $import;

        parent::__construct(
            null
        );
    }
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('zrcms:import')

            // the short description shown while running "php bin/console list"
            ->setDescription('Imports data to ZRCMS.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Example: zrcms:import --file data.json')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return OutputInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument('file');
        if (empty($file)) {
            $output->writeln('File to import is required');

            return $output;
        }

        $createdByUserId = 'cli-import';
        $file = realpath($file);

        if (!file_exists($file)) {
            $output->writeln('File to import not found ' . $file);

            return $output;
        }

        $contents = file_get_contents($file);

        $this->import->__invoke(
            $contents,
            $createdByUserId
        );

        $output->writeln('COMPLETE');

        return $output;
    }
}
