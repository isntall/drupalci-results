<?php

namespace DrupalCIResults\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class ProgressCommand
 * @package DrupalCIResults\Command
 */
class ProgressCommand extends BaseCommand {

  protected function configure() {
    $command = $this->getName();
    $this->setName($command)
      ->setDescription('Progress the state of the build on the results site.')
      ->addOption('build', null, InputOption::VALUE_REQUIRED, 'The build to progress.')
      ->addOption('state', null, InputOption::VALUE_REQUIRED, 'The state to assign to the build.');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    parent::execute($input, $output);

    $build = $input->getOption('build');
    $state = $input->getOption('state');
    $api = $this->getApi();
    $api->progress($build, $state);
    $output->writeln('<info>Updated build to the state: ' . $state . '</info>');
  }
}
