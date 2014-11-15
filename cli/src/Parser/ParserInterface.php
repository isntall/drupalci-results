<?php

namespace DrupalCIResults\Parser;

/**
 * @file
 * Defined interface for results parsing.
 */

interface ParserInterface {

  /**
   * Ensure the file has the characteristics of the type of file.
   * @param $file
   * @return boolean
   */
  public function validate($file);

  /**
   * Parses the file and updates the results class.
   * @param ResultsOutput $results
   */
  public function appendResults(&$results);

}
