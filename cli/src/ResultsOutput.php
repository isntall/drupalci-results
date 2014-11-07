<?php

namespace DrupalCIResults;

class ResultsOutput {

  protected $tests = 0;

  protected $assertions = 0;

  protected $failures = 0;

  protected $errors = 0;

  /**
   * Helper function to increment passes.
   */
  public function addTests($tests) {
    $total = $this->getTests() + $tests;
    $this->setTests($total);
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

  /**
   * @return int
   */
  public function getTests() {
    return $this->tests;
  }

  /**
   * @param int $tests
   */
  public function setTests($tests) {
    $this->tests = $tests;
  }

}
