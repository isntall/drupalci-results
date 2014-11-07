<?php

namespace DrupalCIResults;

use XmlIterator\XmlIterator;

class JunitParser {

  protected $file = '';

  public function __construct($file) {
    $this->setFile($file);
  }

  public function appendResults(ResultsOutput &$results) {
    $file = $this->getFile();
    $it = new XmlIterator($file, "testsuite");
    foreach ($it as $k => $v) {
      $tests = !empty($v['@attributes']['tests']) ? $v['@attributes']['tests'] : 0;
      $assertions = !empty($v['@attributes']['assertions']) ? $v['@attributes']['assertions'] : 0;
      $failures = !empty($v['@attributes']['failures']) ? $v['@attributes']['failures'] : 0;
      $errors = !empty($v['@attributes']['errors']) ? $v['@attributes']['errors'] : 0;
      $results->addTests($tests);
      $results->addAssertions($assertions);
      $results->addFailures($failures);
      $results->addErrors($errors);
    }
  }

  /**
   * @return string
   */
  public function getFile() {
    return $this->file;
  }

  /**
   * @param string $file
   */
  public function setFile($file) {
    $this->file = $file;
  }

}
