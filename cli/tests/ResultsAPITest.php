<?php

namespace DrupalCIResults;

/**
 * Class PermutationTest
 * @package PrivateTravis
 */
class PermutationTest extends \PHPUnit_Framework_TestCase {

  public function testSummary() {
    // This tests a combination of Drupal and Junit parsing.
    $results = new ResultsAPI();
    $message = $results->summary(dirname(__FILE__). '/assets');
    $expected = "Assertions: 12, Failures: 113 and 1000 errors.";
    $this->assertEquals($expected, $message);
  }

}
