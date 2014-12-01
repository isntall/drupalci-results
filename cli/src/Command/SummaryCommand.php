<?php

namespace DrupalCIResults\Command;

use DrupalCIResults\Parser\ParserResults;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

/**
 * Class SummaryCommand
 * @package DrupalCIResults
 */
class SummaryCommand extends BaseCommand {

  protected function configure() {
    $command = $this->getName();
    $this->setName($command)
      ->setDescription('Generate a summary message based on the artefacts.')
      ->addOption('build', null, InputOption::VALUE_REQUIRED, 'The build to upload the summary to.')
      ->addOption('artefacts', null, InputOption::VALUE_REQUIRED, 'The path to the build artefacts.', '.');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    parent::execute($input, $output);

    $artefacts = $input->getOption('artefacts');
    $build = $input->getOption('build');

    // Build the results.
    $summary = new ParserResults();
    $finder = new Finder();
    $finder->files()->in($artefacts);
    foreach ($finder as $file) {
      $this->parseFile($file, $summary);
    }

    $message = $summary->printResults();
    if (!empty($message)) {
      $output->writeln('<info>' . $message .'</info>');

      // Also submit to the Results site is specified.
      if ($build) {
        $api = $this->getApi();
        $api->summary($build, $message);
      }
    }
    else {
      $output->writeln('<error>Failed to generate the summary message.</error>');
    }
  }

  /**
   * Parse a file and append the results to the summary object.
   * @param $file
   * @param $summary
   */
  private function parseFile($file, &$summary) {
    // Load up all the classes.
    $parsers = Yaml::parse('parsers.yml');

    // If the file is valid we append the results to the summary object.
    foreach ($parsers as $parser) {
      $path = $file->getRealpath();
      $object = new $parser();
      $object->setFile($path);
      if ($object->validate($path)) {
        $object->appendResults($summary);
      }
    }
  }

}
