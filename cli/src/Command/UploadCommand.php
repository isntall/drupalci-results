<?php

namespace DrupalCIResults\Command;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Finder\Finder;

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

    // Ensure we have the S3 details in the configuratin provided upsteam.
    $config = $this->getConfig();
    if (empty($config['s3_bucket'])) {
      throw new \Exception('Please provide a AWS S3 bucket in the config file.');
    }
    if (empty($config['s3_key'])) {
      throw new \Exception('Please provide a AWS S3 key in the config file.');
    }

    // Upload the artefacts to S3.
    $urls = array();

    // Instantiate an S3 client
    $options = array(
      'key' => $config['s3_key'],
      'secret' => $config['s3_secret'],
    );
    $s3 = S3Client::factory($options);

    // Build the results.
    $finder = new Finder();
    $finder->files()->in($artefacts);
    foreach ($finder as $file) {
      // Upload a publicly accessible file. The file size, file type, and MD5 hash
      // are automatically calculated by the SDK.
      try {
        $result = $s3->putObject(array(
          'Bucket' => $config['s3_bucket'],
          'Key'    => $build . '/' . $file->getFilename(),
          'Body'   => fopen($file->getRealpath(), 'r'),
          'ACL'    => 'public-read',
        ));
        $urls[] = array(
          'title' => $file->getFilename(),
          'url' => $result['ObjectURL'],
        );
      } catch (S3Exception $e) {
        $output->writeln('<error>Failed to upload artefact: ' . $file->getFilename() . '</error>');
      }
    }

    $api = $this->getApi();
    $api->artefacts($build, $urls);
    $output->writeln('<info>Successfully upload artefacts to build: ' . $build . '</info>');
  }
}
