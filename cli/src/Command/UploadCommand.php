<?php

namespace DrupalCIResults\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * Command to upload build artefacts to the results site.
 * @package DrupalCIResults
 */
class UploadCommand extends BaseCommand {

  protected function configure() {
    $command = $this->getName();
    $this->setName($command)
      ->setDescription('Upload the build artefacts to the results site bulid.')
      ->addOption('build', null, InputOption::VALUE_REQUIRED, 'The ID of the build on the results site.')
      ->addOption('artefacts', null, InputOption::VALUE_REQUIRED, 'The path to the build artefacts.', '.');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    parent::execute($input, $output);

    $build = $input->getOption('build');
    $artefacts = $input->getOption('artefacts');

    // Upload the artefacts to S3.
    $urls = array();

    $api = $this->getApi();
    $success = $api->upload($build, $urls);

    if ($success) {
      $output->writeln('<info>Successfully upload artefacts to build: ' . $build . '</info>');
    }
    else {
      $output->writeln('<error>Failed to upload artefacts.</error>');
    }
  }
}
