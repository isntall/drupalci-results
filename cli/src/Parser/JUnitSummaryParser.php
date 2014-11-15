<?php

namespace DrupalCIResults\Parser;

use XmlIterator\XmlIterator;

/**
 * Class JunitSummaryParser
 * @package DrupalCIResults
 */
class JUnitSummaryParser implements ParserInterface {

  protected $file = '';

  public function validate($file) {
    if (strpos($file, '.xml') !== FALSE) {
      // @todo, ensure this is a junit file.
      return true;
    }
    return false;
  }

  public function appendResults(&$results) {
    $file = $this->getFile();
    $it = new XmlIterator($file, "testsuite");
    foreach ($it as $k => $v) {
      $assertions = !empty($v['@attributes']['assertions']) ? $v['@attributes']['assertions'] : 0;
      $failures = !empty($v['@attributes']['failures']) ? $v['@attributes']['failures'] : 0;
      $errors = !empty($v['@attributes']['errors']) ? $v['@attributes']['errors'] : 0;
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
