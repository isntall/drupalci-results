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
class ResultsTest extends WebTestBase {

  /**
   * The install profile.
   * @var string
   */
  protected $profile = 'results';

  /**
   * Tests Results installation profile.
   */
  function testResults() {
    // Create a user we can test for posting, our REST testing depends on it.
    $account = $this->drupalCreateUser(array(
      'create result content',
      'edit any result content',
    ));
    $this->drupalLogin($account);

    // Create a new build.
    //$text_file = current($this->drupalGetTestFiles('text'));
    $edit = array(
      'title[0][value]' => 'My awesome build',
      'field_id[0][value]' => 'abc123',
      'field_state[0][target_id]' => 'New (1)',
      'field_summary[0][value]' => 'Tests: 5, Assertions: 12, Failures: 0 and 0 errors.',
      'field_dispatcher[0][url]' => 'http://localhost/build/1',
      'field_console[0][url]' => 'http://localhost/build/1/log',
      //'files[field_artefacts_0]' => array(
      //  drupal_realpath($text_file->uri),
      //),
    );
    $this->drupalPostForm('node/add/result', $edit, t('Save'));

    // Check the build status page has all we need to show.
    $this->assertText('Tests: 5, Assertions: 12, Failures: 0 and 0 errors.');
    $this->assertText('Latest builds');

    // Lets see if the build can be found on the front page with the new state.
    $this->drupalGet('');
    $this->assertText('My awesome build');
    $this->assertText('New');

    // Promote build to "Building".
    $edit = array(
      'field_state[0][target_id]' => 'Building (2)',
    );
    $this->drupalPostForm('node/1/edit', $edit, t('Save'));
    $this->drupalGet('');
    $this->assertText('My awesome build');
    $this->assertText('Building');
  }

}
