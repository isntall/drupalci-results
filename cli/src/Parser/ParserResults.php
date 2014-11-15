<?php

namespace DrupalCIResults\Parser;

/**
 * @file
 * A class to track the number of passes, fails and errors.
 */

class ParserResults implements ParserResultsInterface {

  protected $assertions = 0;

  protected $failures = 0;

  protected $errors = 0;

  /**
   * Print the results into a human readable string.
   * @return string
   */
  public function printResults() {
    $assertions = $this->getAssertions();
    $failures = $this->getFailures();
    $errors = $this->getErrors();
    return "Assertions: " . $assertions . ", Failures: " . $failures . " and " . $errors . " errors.";
  }

  /**
   * Helper function to increment fails.
   */
  public function addAssertions($assertions) {
    $total = $this->getAssertions() + $assertions;
    $this->setAssertions($total);
  }

  /**
   * Helper function to increment failures.
   */
  public function addFailures($failures) {
    $total = $this->getFailures()
      + $failures;
    $this->setFailures($total);
  }

  /**
   * Helper function to increment errors.
   */
  public function addErrors($errors) {
    $total = $this->getErrors() + $errors;
    $this->setErrors($total);
  }

  /**
   * @return int
   */
  public function getAssertions() {
    return $this->assertions;
  }

  /**
   * @param int $assertions
   */
  public function setAssertions($assertions) {
    $this->assertions = $assertions;
  }

  /**
   * @return int
   */
  public function getErrors() {
    return $this->errors;
  }

  /**
   * @param int $errors
   */
  public function setErrors($errors) {
    $this->errors = $errors;
  }

  /**
   * @return int
   */
  public function getFailures() {
    return $this->failures;
  }

  /**
   * @param int $failures
   */
  public function setFailures($failures) {
    $this->failures = $failures;
  }

}
