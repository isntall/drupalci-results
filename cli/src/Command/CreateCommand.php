<?php

namespace DrupalCIResults\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class CreateCommand
 * @package DrupalCIResults\Command
 */
class CreateCommand extends BaseCommand {

  protected function configure() {
    $command = $this->getName();
    $this->setName($command)
      ->setDescription('Create a new build on the results site.')
      ->addOption('title', null, InputOption::VALUE_REQUIRED, 'The title of the new build to create.', 'admin');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    parent::execute($input, $output);

    $title = $input->getOption('title');
    $api = $this->getApi();
    $location = $api->create($title);

    if ($location) {
      $output->writeln('<info>Build created: ' . $location . '</info>');
    }
    else {
      $output->writeln('<error>Failed to create a new build.</error>');
    }
  }
}
