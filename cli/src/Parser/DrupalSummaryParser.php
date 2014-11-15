<?php

namespace DrupalCIResults\Parser;

use XmlIterator\XmlIterator;

/**
 * Class DrupalSummaryParser
 * @package DrupalCIResults
 */
class DrupalSummaryParser implements ParserInterface {

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
    $it = new XmlIterator($file, "testcase");
    foreach ($it as $k => $v) {
      $failures = !empty($v['failure']) ? 1 : 0;
      $results->addFailures($failures);
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
