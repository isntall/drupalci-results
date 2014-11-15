<?php

namespace DrupalCIResults\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use DrupalCIResults\ResultsAPI;

/**
 * @file
 * Command to get the summary of passes, build or errors from artefacts.
 */

class SummaryCommand extends Command {

  protected function configure() {
    $command = $this->getName();
    $this->setName($command)
      ->setDescription('Generate a summary message based on the artefacts.')
      ->addOption('artefacts', null, InputOption::VALUE_REQUIRED, 'The path to the build artefacts.', '.')
      ->addOption('url', null, InputOption::VALUE_REQUIRED, 'The URL of the results site.', 'http://results.drupalci.org');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $artefacts = $input->getOption('artefacts');
    $url = $input->getOption('url');

    $results = new ResultsAPI($url);
    $message = $results->summary($artefacts);

    if (!empty($message)) {
      $output->writeln('<info>' . $message .'</info>');
    }
    else {
      $output->writeln('<error>Failed to generate the summary message.</error>');
    }
  }
}
