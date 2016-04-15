<?php

namespace CorsBundle;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Classe pour executer la commande d'intallation
 *
 * @copyright   2016
 * @author      jthiriet <thirietjordan@gmail.com>
 * Class CommandExecutor
 * @package CorsBundle
 */
class CommandExecutor
{
    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var Application
     */
    protected $application;

    /**
     * Constructor
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param Application $application
     */
    public function __construct(InputInterface $input, OutputInterface $output, Application $application)
    {
        $this->input = $input;
        $this->output = $output;
        $this->application = $application;
    }

    /**
     * {@inheritdoc}
     */
    public function runCommand($command, $params = array())
    {
        $params = array_merge(
            array('command' => $command),
            $params,
            $this->getDefaultParams()
        );

        $this->application->setAutoExit(false);
        $exitCode = $this->application->run(new ArrayInput($params), $this->output);

        if (0 !== $exitCode) {
            $this->output->writeln(
                sprintf('<error>The command terminated with an error code: %u.</error>', $exitCode)
            );
            exit($exitCode);
        }

        return $this;
    }

    /**
     * Get default parameters
     *
     * @return array
     */
    protected function getDefaultParams()
    {
        $defaultParams = array('--no-debug' => true);

        if ($this->input->hasOption('env')) {
            $defaultParams['--env'] = $this->input->getOption('env');
        }

        if ($this->input->hasOption('verbose')) {
            $defaultParams['--verbose'] = $this->input->getOption('verbose');
        }

        return $defaultParams;
    }
}
