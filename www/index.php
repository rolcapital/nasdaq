<?php

/**
 * @package Nasdaq
 * @version 0.0.1
 * @author  Roderic Linguri <roderic@rolcapital.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once(dirname(__DIR__).DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'autoload.php');

$registry = new NasdaqRegistry();

header('Content-Type: application/json');
echo json_encode($registry->index());
