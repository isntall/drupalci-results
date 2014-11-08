<?php

namespace DrupalCIResults;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * @file
 * Command for creating new builds.
 */

class CreateCommand extends Command {

  protected function configure() {
    $command = $this->getName();
    $this->setName($command)
      ->setDescription('Create a new build on the results site.')
      ->addOption('title', null, InputOption::VALUE_REQUIRED, 'The title of the new build to create.', 'admin')
      ->addOption('username', null, InputOption::VALUE_REQUIRED, 'The username of the user with authorization to push to the results site.', 'admin')
      ->addOption('password', null, InputOption::VALUE_REQUIRED, 'The password of the user with authorization to push to the results site.', 'admin')
      ->addOption('url', null, InputOption::VALUE_REQUIRED, 'The URL of the results site.', 'http://results.drupalci.org');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $title = $input->getOption('title');
    $username = $input->getOption('username');
    $password = $input->getOption('password');
    $url = $input->getOption('url');

    $results = new ResultsAPI($url);
    $results->setAuth($username, $password);
    $success = $results->create($title);

    if ($success) {
      $output->writeln('<info>Created a new build.</info>');
    }
    else {
      $output->writeln('<error>Failed to create a new build.</error>');
    }
  }
}
