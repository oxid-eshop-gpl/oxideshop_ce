<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Setup\Command;

use OxidEsales\DatabaseViewsGenerator\ViewsGenerator;
use OxidEsales\EshopCommunity\Internal\Framework\Console\Command\NamedArgumentsTrait;
use OxidEsales\EshopCommunity\Internal\Setup\Database\Exception\DatabaseExistsException;
use OxidEsales\EshopCommunity\Internal\Setup\Database\Exception\DatabaseConnectionException;
use OxidEsales\EshopCommunity\Internal\Setup\Database\Service\DatabaseCheckerInterface;
use OxidEsales\EshopCommunity\Internal\Setup\Database\Service\DatabaseCreatorInterface;
use OxidEsales\EshopCommunity\Internal\Setup\Database\Service\DatabaseInitiatorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class DatabaseSetupCommand extends Command
{
    use NamedArgumentsTrait;

    private const DB_HOST = 'db-host';
    private const DB_PORT = 'db-port';
    private const DB_NAME = 'db-name';
    private const DB_USER = 'db-user';
    private const DB_PASSWORD = 'db-password';
    private const FORCE_INSTALLATION = 'force-installation';

    /**
     * @var DatabaseCreatorInterface
     */
    private $databaseCreator;

    /**
     * @var DatabaseInitiatorInterface
     */
    private $databaseInitiator;

    public function __construct(
        DatabaseCreatorInterface $databaseCreator,
        DatabaseInitiatorInterface $databaseInitiator
    ) {
        parent::__construct();

        $this->databaseCreator = $databaseCreator;
        $this->databaseInitiator = $databaseInitiator;
    }

    protected function configure()
    {
        $this
            ->addOption(self::DB_HOST, null, InputOption::VALUE_REQUIRED)
            ->addOption(self::DB_PORT, null, InputOption::VALUE_REQUIRED)
            ->addOption(self::DB_NAME, null, InputOption::VALUE_REQUIRED)
            ->addOption(self::DB_USER, null, InputOption::VALUE_REQUIRED)
            ->addOption(self::DB_PASSWORD, null, InputOption::VALUE_REQUIRED)
            ->addOption(self::FORCE_INSTALLATION, null, InputOption::VALUE_NONE);
            $this->setDescription('Performs initial database setup');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->checkRequiredCommandOptions($this->getDefinition()->getOptions(), $input);

        $output->writeln('<info>Creating database...</info>');
        try {
            $this->createDatabase($input);
        } catch (DatabaseExistsException $exception) {
            if (!$this->forceDatabaseInstallation($input)) {
                $helper = $this->getHelper('question');
                $question = new ConfirmationQuestion($this->getQuestionText($input), false);

                if (!$helper->ask($input, $output, $question)) {
                    $output->writeln('<info>Setup has been canceled.</info>');
                    return Command::SUCCESS;
                }
            }
        }

        $output->writeln('<info>Initializing database...</info>');
        $this->initializeDatabase($input);

        $output->writeln('<info>Setup has been finished.</info>');

        return Command::SUCCESS;
    }

    /**
     * @param InputInterface $input
     * @return string
     */
    private function getQuestionText(InputInterface $input): string
    {
        return sprintf('Seems there is already OXID eShop installed in database %s. Do you want to overwrite all 
        existing data and install it anyway? [y/N] ', $input->getOption(self::DB_NAME));
    }

    /**
     * @param InputInterface $input
     * @return bool
     */
    private function forceDatabaseInstallation(InputInterface $input): bool
    {
        $value = $input->getOption(self::FORCE_INSTALLATION);
        return isset($value) && $value;
    }

    /**
     * @param InputInterface $input
     * @throws DatabaseExistsException
     * @throws DatabaseConnectionException
     */
    private function createDatabase(InputInterface $input): void
    {
        $this->databaseCreator->createDatabase(
            $input->getOption(self::DB_HOST),
            (int) $input->getOption(self::DB_PORT),
            $input->getOption(self::DB_USER),
            $input->getOption(self::DB_PASSWORD),
            $input->getOption(self::DB_NAME));
    }

    private function initializeDatabase(InputInterface $input): void
    {
        $this->databaseInitiator->initiateDatabase(
            $input->getOption(self::DB_HOST),
            (int) $input->getOption(self::DB_PORT),
            $input->getOption(self::DB_USER),
            $input->getOption(self::DB_PASSWORD),
            $input->getOption(self::DB_NAME));
        $this->generateViews();
    }

    private function generateViews(): void
    {
        (new ViewsGenerator())->generate();
    }
}
