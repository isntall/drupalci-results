<?php

/**
 * @file
 * Contains Drupal\results\Tests\ResultsRest.
 */

namespace Drupal\results\Tests;

use Drupal\Core\Language\LanguageInterface;
use Drupal\simpletest\WebTestBase;
use Drupal\taxonomy\Entity\Vocabulary;

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

    // Imitate adding tagging information for results.
    $tags = array(
      $this->createTagTerm('8.x-dev'),
      $this->createTagTerm('results-1.x-1.0'),
    );
    foreach ($tags as $tag) {
      $edit['field_tags[]'][] = $tag->id();
    }
    $this->drupalPostForm('node/add/result', $edit, t('Save'));

    // Check the build status page has all we need to show.
    $this->assertText('Tests: 5, Assertions: 12, Failures: 0 and 0 errors.');
    $this->assertText('Latest builds');

    // Assert the tags were also added.
    foreach ($tags as $tag) {
      $this->assertText($tag->label());
    }

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

  /**
   * Create a tag term for applying to a result.
   */
  protected function createTagTerm($name) {
    $vocabulary = \Drupal::entityManager()->getStorage('taxonomy_vocabulary')->load('tags');
    $term = \Drupal::entityManager()->getStorage('taxonomy_term')->create(array(
      'name' => $name,
      'vid' => $vocabulary->id(),
      'langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED,
    ));
    $term->save();
    return $term;
  }
}
