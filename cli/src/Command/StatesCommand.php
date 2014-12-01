<?php

namespace DrupalCIResults\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class StatesCommand
 * @package DrupalCIResults\Command
 */
class StatesCommand extends BaseCommand {

  protected function configure() {
    $command = $this->getName();
    $this->setName($command)
      ->setDescription('Show the states that can be set on the remote build site.');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    parent::execute($input, $output);

    $api = $this->getApi();
    $states = $api->states();

    $table = $this->getHelper('table');
    $table
      ->setHeaders(array('ID', 'Name', 'Percentage'))
      ->setRows($states)
    ;
    $table->render($output);

  }
}
