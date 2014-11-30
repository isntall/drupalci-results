<?php

namespace DrupalCIResults\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use DrupalCIResults\ResultsAPI;

/**
 * @file
 * Command to show the states that can be set on the remote build site.
 */

class StatesCommand extends Command {

  protected function configure() {
    $command = $this->getName();
    $this->setName($command)
      ->setDescription('Show the states that can be set on the remote build site.')
      ->addOption('url', null, InputOption::VALUE_REQUIRED, 'The URL of the results site.', 'http://results.drupalci.org');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $url = $input->getOption('url');

    $results = new ResultsAPI();
    $results->setUrl($url);
    $states = $results->states();

    $table = $this->getHelper('table');
    $table
      ->setHeaders(array('ID', 'Name', 'Percentage'))
      ->setRows($states)
    ;
    $table->render($output);

  }
}
