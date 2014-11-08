<?php

namespace DrupalCIResults;

/**
 * @file
 * Defined interface for results parsing.
 */

interface ParserInterface {

  public function appendResults(ResultsOutput &$results);

}
