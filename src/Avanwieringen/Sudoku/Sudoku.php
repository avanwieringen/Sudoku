<?php

namespace Avanwieringen\Sudoku;

use Avanwieringen\Collections\Tools;

class Sudoku {
    
    /**
     * Values of the Sudoku with '0','.' or ' ' being an empty cell
     * @var String 
     */
    private $values;
    
    /**
     * Number of columns in the Sudoku
     * @var int 
     */
    private $cols;
    
    /**
     * Number of rows in the Sudoku
     * @var int
     */
    private $rows;
    
    /**
     * Number of sectors in the Sudoku
     * @var int
     */
    private $secs;
    
    /**
     * Number of cells in the Sudoku
     * @var int 
     */
    private $cells;
    
    /** 
     * Maximum value of a cell
     * @var int 
     */
    private $maxValue;
    
    /**
     * Initializes Sudoku with a specific size
     * @param Array|String $values An array of values or a string of values
     */
    public function __construct($values = array()) {
        /** check if $size is square and dimensions are power of 2
        $dim     = pow($size, 0.25);
        if($dim !== floor($dim)) {
            throw new \InvalidArgumentException('$size^(1/4) must be an integer');
        }   
        $this->values   = array_fill(0, $size, 0);
        $this->cols     = sqrt($size);
        $this->rows     = sqrt($size);
        $this->secs     = sqrt($size);
        $this->maxValue = sqrt($size);
        
        $this->setValues(array_fill(0, $size, 0));**/
        
        if(is_array($values) && count($values) == 0) {
            $values = array_fill(0, 81, 0);
        } 
        $count = is_array($values) ? count($values) : strlen($values);
        $this->setSize($count);
        $this->setValues($values);
    }
    
    /**
     * Sets the size of the Sudoku. The Sudoku is cleared.
     * @param int $size 
     */
    public function setSize($size = 81) {
        $dim     = pow($size, 0.25);
        if($dim !== floor($dim)) {
            throw new \InvalidArgumentException('$size^(1/4) must be an integer');
        }
        
        $this->cols     = sqrt($size);
        $this->rows     = sqrt($size);
        $this->secs     = sqrt($size);
        $this->maxValue = sqrt($size);    
        $this->cells    = $size;
        $this->setValues(array_fill(0, $size, 0));
    }
    
    /**
     * Sets the values of the Sudoku with '0','.' or ' ' being an empty cell
     * @param String|Array $values Values
     */
    public function setValues($values) {
        if(is_array($values)) {
            $maxVal = $this->maxValue;
            if(count($values)!== $this->cells) {
                throw new \InvalidArgumentException(sprintf('$values must either be a string or an array consisting of %d characters or integers', $this->cells));
            } //elseif(count(array_filter($values, function($v) use ($maxVal) { return (is_int($v) && ($v >= 0) && ($v <= $maxVal)); })) !== count($this->values)) {
                elseif(count(array_filter($values, array($this,'isValidNumber'))) !== $this->cells) {
               throw new \InvalidArgumentException(sprintf('Every value in $values should be an integer between 0 and %d', $this->maxValue)); 
            }            
            $this->values = $values;
        } elseif(is_string($values)) {
            if(strlen($values)!== $this->cells) {
                throw new \InvalidArgumentException(sprintf('$values must either be a string or an array consisting of %d characters or integers', $this->cells));
            }            
            $values = array_map(array($this,'parseNumber'), str_split($values));
            $this->values = $values;
        }
    }
    
    /**
     * Sets the value of a specific Sudoku cell
     * @param int $r Row, 0-index
     * @param int $c Column, 0-index
     * @param int|String $v Value to set
     */
    public function setValue($r, $c, $v) {    
        $this->values[$this->getIndex($r, $c)] = $this->parseNumber($v);
    }
    
    /** 
     * Get a specific cell value
     * @param int $r Row
     * @param int $c Column
     * @return int Cell Value 
     */
    public function getValue($r, $c) {
        return $this->values[$this->getIndex($r, $c)];
    }
    
    /**
     * Return the Sudoku as an array
     * @return Array Integer array with the Sudoku values
     */
    public function toArray() {
        $values = array(array_fill(0, $this->rows, array_fill(0, $this->cols, 0)));
        for($i_r = 0; $i_r < $this->rows; $i_r++) {
            for($i_c = 0; $i_c < $this->cols; $i_c++) {
                $values[$i_r][$i_c] = $this->getValue($i_r, $i_c);
            }
        }
        return $values;
    }
    
    /** 
     * Return the number of rows in the Sudoku
     * @return int 
     */
    public function getRowCount() {
        return $this->rows;
    }
    
    /** 
     * Return the number of columns in the Sudoku
     * @return int 
     */
    public function getColumnCount() {
        return $this->cols;
    }
    
    /** 
     * Return the number of sectors in the Sudoku
     * @return int 
     */
    public function getSectorCount() {
        return $this->secs;
    }
    
    /**
     * Get values of a row
     * @param int $r 
     * @return Array
     */
    public function getRow($r) {
        $values = array();
        for($i_c = 0; $i_c < $this->cols; $i_c++) {
            $values[] = $this->getValue($r, $i_c);
        }
        return $values;
    }
    
    /**
     * Get values of a column
     * @param int $c 
     * @return Array
     */
    public function getColumn($c) {
        $values = array();
        for($i_r = 0; $i_r < $this->rows; $i_r++) {
            $values[] = $this->getValue($i_r, $c);
        }
        return $values;
    }
        
    /**
     * Get values of a sector
     * @param int $s
     * @return Array 
     */
    public function getSector($s) {
        if(!is_numeric($s))  {
            throw new \InvalidArgumentException('Index is not an integer');
        } elseif($s < 0 || $s > ($this->secs - 1)) {
            throw new \OutOfBoundsException(sprintf('$s should be between 0 and %d', $this->secs -1));
        }
        $s = intval($s);        
        $vals = array();
        for($r = floor($s /sqrt($this->rows)) * sqrt($this->rows); $r < (floor($s/sqrt($this->rows)) + 1) * sqrt($this->rows); $r++) {
            for($c = $s%sqrt($this->cols) * sqrt($this->cols); $c < ($s%sqrt($this->cols) + 1) * sqrt($this->cols);  $c++) {
                $vals[] = $this->getValue($r, $c);
            }
        }
        return $vals;
    }
    
    /**
     * Checks wether or not the Sudoku is solvable
     * @return boolean
     */
    public function isSolvable() {
        if($this->isSolved()) return true;
        foreach($this->values as $i => $v) {
            if(!$this->isValidCell($this->getRowFromIndex($i), $this->getColumnFromIndex($i))) return false;
        }
        return true;
    }
    
    /**
     * Checks wether or not the Sudoky is solved
     * @return boolean 
     */
    public function isSolved() {
        return count(array_filter($this->values)) == count($this->values);
    }
    
    /** 
     * Checks wether or not a cell is valid
     * @param int $r
     * @param int $c 
     * @return boolean
     */
    public function isValidCell($r, $c) {
        if($this->isFilledCell($r, $c)) return true;      
        return count($this->getChoices($r, $c)) != 0;        
    }
    
    /**
     * Checks if cell is filled, not if it is valid
     * @param int $r
     * @param int $c
     * @return boolean 
     */
    public function isFilledCell($r, $c) {
        return !$this->getValue($r, $c) == 0;
    }
    
    /**
     * Returns the choices of a cell
     * @param type $r
     * @param type $c 
     * @return Array
     */
    public function getChoices($r, $c) {
        $choices = array();
        if($this->isFilledCell($r, $c)) return $choices;        
        $vals = array_unique(array_filter(array_merge($this->getRow($r), $this->getColumn($c), $this->getSectorFromRowCol($r, $c))));
        sort($vals);
      
        $vals = array_diff(range(1, $this->maxValue), $vals);
        return $vals;
    }
    
    /**
     * Returns whether or not a cell has any choices left
     * @param int $r
     * @param int $c
     * @return boolean 
     */
    public function hasChoices($r, $c) {
        return count($this->getChoices($r, $c)) > 0;
    }
    
    protected function filterValues($input) {
        $input = array_filter($input, function($v) { return $v > 0; });
        return array_diff(range(1, $this->maxValue), $input);
    }
    
    /**
     * Returns the rownumber from the 1-dim index
     * @param int $index
     * @return int 
     */
    protected function getRowFromIndex($index) {
        return floor($index / $this->cols);
    }
    
    /**
     * Returns the columnnumber from the 1-dim index
     * @param int $index
     * @return int 
     */
    protected function getColumnFromIndex($index) {
        return $index%$this->cols;
    }
    
    /**
     * Returns the sectornumber from the 1-dim index
     * @param int $index
     * @return int 
     */
    protected function getSectorFromIndex($index) {
        $r = $this->getRowFromIndex($index);
        $c = $this->getColumnFromIndex($index);  
        return $this->getSector((floor($r / sqrt($this->rows))*sqrt($this->rows) + floor($c / sqrt($this->cols))));
    }
    
    /**
     * Returns the sectornumber from rows and columns
     * @param int $r
     * @param int $c
     * @return int 
     */
    protected function getSectorFromRowCol($r, $c) {
        return $this->getSectorFromIndex($this->getIndex($r, $c));
    }
    
    /**
     * Checks wether or not the row and column indices are valid
     * @param int $r
     * @param int $c
     * @return boolean or an Exception on error 
     */
    protected function checkColumnAndRowIndex($r, $c) {
        if(!is_numeric($r) || !is_numeric($c)) {
            throw new \InvalidArgumentException('Row and column indices must be integers');
        }
        
        if($r >= $this->rows || $c >= $this->cols) {
            throw new \OutOfRangeException('Row and column index must be within the range 0..' . ($this->maxValue - 1));
        }
        return true;
    }
    
    /**
     * Return the index in the 1-dim array belonging to a column and row index
     * @param int $r Row
     * @param int $c Columnn
     * @return type 
     */
    protected function getIndex($r, $c) {
        $this->checkColumnAndRowIndex($r, $c);    
        return ($r*$this->maxValue + $c);
    }
    
    /**
     * Internal function to check if a variable is a valid Sudoku cell value
     * @param String|int $v Value
     * @return Boolean 
     */
    protected function isValidNumber($v) {
        $empty = array('0','.',' ');
        if(is_string($v) || is_int($v)) {
            if(in_array($v, $empty)) {
                return true;
            }
            
            if(intval($v) > 0 && intval($v) <= $this->maxValue) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Internal function to parse a variable as a suitable Sudoky cell value
     * @param String|int $v
     * @return int 
     */    
    protected function parseNumber(&$v) {
        if(!$this->isValidNumber($v)) {
            throw new \InvalidArgumentException(sprintf("Value must be a String or an integer within the range 0..%d. '%s' given.", $this->maxValue, $v));
        }
        return intval($v);
    }
    
    
}
