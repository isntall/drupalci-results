<?php

namespace DrupalCIResults;

use Guzzle\Http\Client;

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
   * Constructor.
   */
  public function __construct($url) {
    if ($url) {
      $this->setUrl($url);
    }
    else {
       // @todo, we need to fail here.
    }
  }

  /**
   * Helper function to setup authentication.
   */
  public function setAuth($username, $password) {
    // @todo, add checks.
    $this->setUsername($username);
    $this->setPassword($password);
  }

  /**
   * Creates a build record.
   */
  public function create($title) {
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
    );
    $data = json_encode($node);
    $response = $client->post('entity/node', array('Content-type' => 'application/hal+json'), $data)->setAuth($username, $password)->send();

    return $response->getStatusCode() == 201;
  }

  /**
   * Updates the build in accordance with the workflow.
   */
  public function progress($id, $state) {
    // @todo, add checks.
  }

  /**
   * Calculate the "Summary" of the build and
   */
  public function upload($id, $artefacts) {
    // @todo, add checks.
  }

  /**
   * Build a "Summary" based on the artefacts.
   */
  public function summary($artefacts) {
    // @todo, add checks.
  }

  /** public function send() {

  }  */

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