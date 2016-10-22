<?php

/**
 * @package Nasdaq
 * @version 0.0.1
 * @author  Roderic Linguri <roderic@rolcapital.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once(dirname(__DIR__).DIRECTORY_SEPARATOR.'autoload.php');

/** Test Traded **/
echo PHP_EOL.'------TEST Nasdaq Traded------'.PHP_EOL;

// download the new list
$traded = new NasdaqTraded();

echo 'row for symbol BA = '.print_r($traded->rowFromSymbol('BA'), true).PHP_EOL;

/** Test Registry **/
echo PHP_EOL.'------TEST Nasdaq Registry------'.PHP_EOL;

// load the current registry
$registry = new NasdaqRegistry();

echo 'last ID: '.$registry->lastId().PHP_EOL;

echo 'row for symbol AAPL = '.print_r($registry->rowFromSymbol('AAPL'),true).PHP_EOL;

echo 'row for id 2497 = '.print_r($registry->rowFromId(2497),true).PHP_EOL;

// print_r($traded_securities);
