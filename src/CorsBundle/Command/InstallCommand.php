<?php
namespace CorsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use CorsBundle\CommandExecutor;

/**
 * Definition de la commande pour ajouter un nouveau client à l'api
 *
 * @copyright   2014 Thiriet Jordan
 * @author      jthiriet <thirietjordan@gmail.com>
 * Class CreateClientCommand
 * @package CorsBundle\Command
 */
class InstallCommand extends ContainerAwareCommand
{

    /**
     * @var CommandExecutor
     */
    private $commandExecutor;

    /**
     * @param InputInterface $input Entrée sur la console
     * @param OutputInterface $output Affichage sur la console
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->commandExecutor = new CommandExecutor(
            $input,
            $output,
            $this->getApplication()
        );
    }

    protected function configure()
    {
        $this
            ->setName('gpp:install')
            ->setDescription('Install Gpp');
    }

    /**
     * Execution de la commande pour ajouter un nouveau client de OAuth
     *
     * @param InputInterface $input Entrée au clavier sur la console
     * @param OutputInterface $output Affichage sur la console
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /*Supression de la base de données*/
        $output->writeln('<info>Prepare database schema</info>');
        $connection = $this->getContainer()->get('doctrine')->getConnection();

        if (in_array('symfony', $connection->getSchemaManager()->listDatabases())) {
            $this->commandExecutor->runCommand('doctrine:database:drop', array('--force' => true));
        }

        /*Création de la base de données*/
        $this->commandExecutor->runCommand('doctrine:database:create');
        if ($connection->isConnected()) {
            $connection->close();
        }

        /*Création des tables dans la base de données*/
        $this->commandExecutor->runCommand('doctrine:schema:create')
            ->runCommand('doctrine:schema:update', array('--force' => true, '--no-interaction' => true));


        $output->writeln('<info>Load fixtures.</info>');
        $params = array(
            '--fixtures' => 'src/CorsBundle/DataFixtures/Install',
            '--no-interaction' => true,
            '--append' => true
        );


        /*Load des fixtures dans le dossier DataFixtures*/
        $this->commandExecutor->runCommand('doctrine:fixtures:load', $params);

        if(!is_dir('web/images')) {
            $output->writeln('<info>Create folder images</info>');
            mkdir ('web/images');
        }

        if(!is_dir('web/images/avatar')) {
            $output->writeln('<info>Create folder avatar</info>');
            mkdir('web/images/avatar');
        }
    }
}