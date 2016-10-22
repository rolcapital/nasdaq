<?php

/**
 * @package Nasdaq
 * @version 0.0.1
 * @author  Roderic Linguri <roderic@rolcapital.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once(dirname(__DIR__).DIRECTORY_SEPARATOR.'autoload.php');

// load the current registry
global $registry;
$registry = new NasdaqRegistry();

// download the new list
global $traded;
$traded = new NasdaqTraded();

// iterate through newly acquired list to see if any need to be added
foreach ($traded->securities() as $k=>$v) {

  // check to see if symbol exists in registry
  if ($row = $registry->rowFromSymbol($k)) {
    // don't need to add symbol
  } else {
    $registry->addSymbol($k);
  }

}

// deactivate any symbols not present in new file
foreach ($registry->securities() as $k=>$v) {
  if ($active = $traded->rowFromSymbol($k)) {
    // don't deactivate
  } else {
    $registry->deactivateSymbol($k);
  }
}


$registry->saveToDisk();
 