<?php

namespace DrupalCIResults;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * @file
 * Command to progress the build on the results site.
 */

class ProgressCommand extends Command {

  protected function configure() {
    $command = $this->getName();
    $this->setName($command)
      ->setDescription('Update the state of the build on the results site.')
      ->addOption('id', null, InputOption::VALUE_REQUIRED, 'The ID of the build on the results site.')
      ->addOption('state', null, InputOption::VALUE_REQUIRED, 'The state to assign to the build.', 'admin')
      ->addOption('username', null, InputOption::VALUE_REQUIRED, 'The username of the user with authorization to push to the results site.', 'admin')
      ->addOption('password', null, InputOption::VALUE_REQUIRED, 'The password of the user with authorization to push to the results site.', 'admin')
      ->addOption('url', null, InputOption::VALUE_REQUIRED, 'The URL of the results site.', 'http://results.drupalci.org');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $id = $input->getOption('id');
    $state = $input->getOption('state');
    $username = $input->getOption('username');
    $password = $input->getOption('password');
    $url = $input->getOption('url');

    $results = new ResultsAPI($url);
    $results->setAuth($username, $password);
    $success = $results->progress($id, $state);

    if ($success) {
      $output->writeln('<info>Updated the build to the state: ' . $state . '</info>');
    }
    else {
      $output->writeln('<error>Failed to update the state of the build.</error>');
    }
  }
}
