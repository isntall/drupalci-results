<?php

namespace DrupalCIResults;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * @file
 * Command to upload build artefacts to the results site.
 */

class UploadCommand extends Command {

  protected function configure() {
    $command = $this->getName();
    $this->setName($command)
      ->setDescription('Upload the build artefacts to the results site bulid.')
      ->addOption('username', null, InputOption::VALUE_REQUIRED, 'The username of the user with authorization to push to the results site.', 'admin')
      ->addOption('password', null, InputOption::VALUE_REQUIRED, 'The password of the user with authorization to push to the results site.', 'admin')
      ->addOption('url', null, InputOption::VALUE_REQUIRED, 'The URL of the results site.', 'http://results.drupalci.org')
      ->addOption('id', null, InputOption::VALUE_REQUIRED, 'The ID of the build on the results site.')
      ->addOption('artefacts', null, InputOption::VALUE_REQUIRED, 'The path to the build artefacts.', '.');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $username = $input->getOption('username');
    $password = $input->getOption('password');
    $url = $input->getOption('url');
    $id = $input->getOption('id');
    $artefacts = $input->getOption('artefacts');

    $results = new ResultsAPI($url);
    $results->setAuth($username, $password);
    $success = $results->upload($id, $artefacts);

    if ($success) {
      $output->writeln('<info>Successfully upload artefacts to build: ' . $id . '</info>');
    }
    else {
      $output->writeln('<error>Failed to upload artefacts.</error>');
    }
  }
}
