<?php

/**
 * @file
 * Contains Drupal\results\Tests\ResultsRest.
 */

namespace Drupal\results\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Tests results profile installation and functionality.
 *
 * @group results
 */
class ResultsRest extends WebTestBase {

  protected $profile = 'results';

  /**
   * Tests Minimal installation profile.
   */
  function testMinimal() {
    $this->drupalGet('');
  }
}
