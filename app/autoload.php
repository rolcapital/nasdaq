<?php

// load configuration file
require_once(__DIR__.DIRECTORY_SEPARATOR.'etc'.DIRECTORY_SEPARATOR.'config.php');

// set lib directory
$lib = APP_DIR.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR;

// import all files in lib directory
$di = new DirectoryIterator($lib);
foreach ($di as $item) {
  $file = $item->getFilename();
  if (substr($file, 0, 1) != '.') {
    require_once($lib.$file);
  }
}