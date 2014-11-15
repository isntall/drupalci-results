<?php

namespace DrupalCIResults;

use Symfony\Component\Finder\Finder;
use Guzzle\Http\Client;
use Symfony\Component\Yaml\Yaml;
use DrupalCIResults\Parser\ParserResults;

/**
 * @file
 * Decoupled API for the results site backend.
 */

class ResultsAPI {

  /**
   * The username of the user with authorization to push to the results site.
   * @var string
   */
  protected $username = "";

  /**
   * The password of the user with authorization to push to the results site.
   * @var string
   */
  protected $password = "";

  /**
   * The URL of the results site.
   * @var string
   */
  protected $url = "";

  /**
   * The ID of the build on the results site.
   * @var string
   */
  protected $buildId = "";

  /**
   * The path to the build artefacts.
   * @var string
   */
  protected $artefactsDirectory = "";

  /**
   * Helper function to setup authentication.
   */
  public function setAuth($username, $password) {
    if (empty($username) || empty($password)) {
      throw new Exception('Please provide authentication credentials.');
    }
    $this->setUsername($username);
    $this->setPassword($password);
  }

  /**
   * Creates a build record.
   */
  public function create($title) {
    if (empty($title)) {
      throw new Exception('Please provide a title.');
    }
    $username = $this->getUsername();
    $password = $this->getPassword();
    $url = $this->getUrl();
    $client = new Client($url);
    $node = array(
      '_links' => array(
        'type' => array(
          'href' => $url . '/rest/type/node/result',
        )
      ),
      'title' => array(0 => array('value' => $title)),
      // @todo, We need to handle state vs id.
      'field_state' => array(0 => array('target_id' => '1')),
    );
    $data = json_encode($node);
    $response = $client->post('entity/node', array('Content-type' => 'application/hal+json'), $data)->setAuth($username, $password)->send();

    return $response->getStatusCode() == 201;
  }

  /**
   * Updates the build in accordance with the workflow.
   */
  public function progress($id, $state) {
    // @todo, Needs work.
  }

  /**
   * Calculate the "Summary" of the build and
   */
  public function upload($id, $artefacts) {
    // @todo, Needs work.
  }

  /**
   * Build a "Summary" based on the artefacts.
   */
  public function summary($artefacts) {
    // Build the results.
    $summary = new ParserResults();
    $finder = new Finder();
    $finder->files()->in($artefacts);
    foreach ($finder as $file) {
      $this->parseFile($file, $summary);
    }

    // Output the results.
    return $summary->printResults();
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

  /**
   * @return string
   */
  public function getUsername() {
    return $this->username;
  }

  /**
   * @param string $username
   */
  public function setUsername($username) {
    $this->username = $username;
  }

  /**
   * @return string
   */
  public function getArtefactsDirectory() {
    return $this->artefactsDirectory;
  }

  /**
   * @param string $artefactsDirectory
   */
  public function setArtefactsDirectory($artefactsDirectory) {
    $this->artefactsDirectory = $artefactsDirectory;
  }

  /**
   * @return string
   */
  public function getBuildId() {
    return $this->buildId;
  }

  /**
   * @param string $buildId
   */
  public function setBuildId($buildId) {
    $this->buildId = $buildId;
  }

  /**
   * @return string
   */
  public function getPassword() {
    return $this->password;
  }

  /**
   * @param string $password
   */
  public function setPassword($password) {
    $this->password = $password;
  }

  /**
   * @return string
   */
  public function getUrl() {
    return $this->url;
  }

  /**
   * @param string $url
   */
  public function setUrl($url) {
    $this->url = $url;
  }

}