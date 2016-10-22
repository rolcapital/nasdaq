<?php

/**
 * @package Nasdaq
 * @version 0.0.1
 * @author  Roderic Linguri <roderic@rolcapital.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class NasdaqTraded
{

  protected $securities;

  public function __construct()
  {
    $this->securities = array();
    $txt = file_get_contents('ftp://ftp.nasdaqtrader.com/symboldirectory/nasdaqtraded.txt');
    $lines = explode("\r\n", $txt);
    array_shift($lines);
    array_pop($lines);
    array_pop($lines);
    foreach ($lines as $line) {
      $array = explode('|', $line);
      $active = ($array[7] == 'N') ? true : false;
      if ($active) {
        $this->securities[$array[10]] = $active;
      }
    }
  }

  public function securities()
  {
    return $this->securities;
  }

  public function rowFromSymbol($symbol)
  {
    if (isset($this->securities[$symbol])) {
      return $this->securities[$symbol];
    } else {
      return false;
    }
  }

}