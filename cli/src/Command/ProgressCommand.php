<?php

namespace DrupalCIResults\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use DrupalCIResults\ResultsAPI;

/**
 * @file
 * Command to progress the build on the results site.
 */

class ProgressCommand extends Command {

  protected function configure() {
    $command = $this->getName();
    $this->setName($command)
      ->setDescription('Progress the state of the build on the results site.')
      ->addOption('build', null, InputOption::VALUE_REQUIRED, 'The build to progress.')
      ->addOption('state', null, InputOption::VALUE_REQUIRED, 'The state to assign to the build.')
      ->addOption('username', null, InputOption::VALUE_REQUIRED, 'The username of the user with authorization to push to the results site.', 'admin')
      ->addOption('password', null, InputOption::VALUE_REQUIRED, 'The password of the user with authorization to push to the results site.', 'admin')
      ->addOption('url', null, InputOption::VALUE_REQUIRED, 'The URL of the results site.', 'http://results.drupalci.org');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $build = $input->getOption('build');
    $state = $input->getOption('state');
    $username = $input->getOption('username');
    $password = $input->getOption('password');
    $url = $input->getOption('url');

    $results = new ResultsAPI();
    $results->setUrl($url);
    $results->setAuth($username, $password);
    $results->progress($build, $state);

    $output->writeln('<info>Updated build to the state: ' . $state . '</info>');
  }
}
