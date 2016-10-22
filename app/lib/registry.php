<?php

/**
 * @package Nasdaq
 * @version 0.0.1
 * @author  Roderic Linguri <roderic@rolcapital.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class NasdaqRegistry
{

  /** @property *mixed* securities indexed by symbol **/
  protected $securities;

  /** @property *mixed* securities indexed by id **/
  protected $index;

  /** @property *int* last id in index **/
  protected $lastId;
  
  /** @property *str* location of file **/
  protected $filePath;

  /** @method Registry constructor **/
  public function __construct()
  {
    // initialize properties
    $this->securities = array();
    $this->index = array();
    $this->lastId = 0;
    $this->filePath = dirname(__DIR__).DIRECTORY_SEPARATOR.'var'.DIRECTORY_SEPARATOR.'registry.csv';

    // load stored registry
    $csv = file_get_contents($this->filePath);
    $lines = explode(PHP_EOL, $csv);

    // remove the last empty line
    array_pop($lines);

    // iterate through csv lines
    foreach ($lines as $line) {

      // split into values
      $array = explode(',', $line);
      
      // identify components
      $id = intval($array[0]);
      $symbol = $array[1];
      $active = intval($array[2]);

      // compose row      
      $row = array('id' => $id,'symbol' => $symbol,'active' => $active);

      // add to indexes
      $this->securities[$symbol] = $row;
      $this->index[$id] = $row;
      
      // increment last id
      if ($id > $this->lastId) {
        $this->lastId = $id;
      }
      
    }
    
  }

  /** @method add symbol 
    * @param  *str* symbol
    * @return *bool* success
    **/
  public function addSymbol($symbol)
  {
    // make sure symbol does not exist
    if (!isset($this->securities[$symbol])) {

      // create a new Id
			$this->lastId = ($this->lastId + 1);

      // compose row
			$row = array('id' => $this->lastId,'symbol' => $symbol, 'active' => 1);
			
			// add to indexes
			$this->securities[$symbol] = $row;
			$this->index[$this->lastId] = $row;
			
			return true;

    } else {
      return false;
    }
  }
  
  /** @method deactivate symbol 
    * @param  *str* symbol
    * @return *void*
    **/
  public function deactivateSymbol($symbol)
  {
    // isolate the row
    $array = $this->securities[$symbol];
    
    // extract id
    $id = $array['id'];
    
    // compose new row
    $row = array('id' => $id, 'symbol' => $symbol,'active' => 0);
    
    // modify indexes
    $this->securities[$symbol] = $row;
    $this->index[$id] = $row;
    
  }

  /** @method row from symbol
    * @param  *str* symbol
    * @return *mixed* assoc | *bool* 
    **/
  public function rowFromSymbol($symbol)
  {
    if (isset($this->securities[$symbol])) {
      return $this->securities[$symbol];
    } else {
      return false;
    }
  }
  
  /** @method row from id
    * @param  *int* id
    * @return *mixed* assoc | *bool* 
    **/
  public function rowFromId($id)
  {
    if (isset($this->index[$id])) {
      return $this->index[$id];
    } else {
      return false;
    }
  }

  /** @method save to disk
    * @param  *void*
    * @return *void* 
    **/
  public function saveToDisk()
  {
    // make sure index is in order
    ksort($this->index);

    // initialize empty string
    $csv = '';

    // add each row to string
    foreach ($this->index as $k=>$v) {
      $csv .= $v['id'].','.$v['symbol'].','.$v['active'].PHP_EOL;
    }
    
    // write file
    file_put_contents($this->filePath, $csv);
    
  }

  /** @method lastId getter **/
  public function lastId()
  {
    return $this->lastId;
  }

  /** @method securities getter
    * @param  *void*
    * @return *mixed* securities indexed by symbol
    **/
  public function securities()
  {
    return $this->securities;
  }

  /** @method index getter
    * @param  *void*
    * @return *mixed* securities indexed by id
    **/
  public function index()
  {
    return $this->index;
  }

  /** @method active securities
    * @param  *void*
    * @return *mixed* securities indexed by id
    **/
  public function activeIndex()
  {
    $active = array();
    foreach ($this->index as $k=>$v) {
      if ($v['active'] == 1) {
        $active[$k] = $v['symbol'];
      }
    }
    return $active;
  }

}